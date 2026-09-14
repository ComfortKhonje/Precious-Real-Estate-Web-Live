<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

/**
 * CMS > Staff Accounts. Added 2026-09-14 with roles — the host has no shell
 * access, so accounts can't be managed with `php artisan prec:create-user`
 * there. Admins manage admins and editors; only a Super Admin can create,
 * edit or remove another Super Admin (User::canManage()).
 */
class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->filled('search'), function ($query) use ($request) {
                $term = '%'.$request->input('search').'%';
                $query->where(fn ($q) => $q->where('name', 'like', $term)->orWhere('email', 'like', $term));
            })
            ->orderByRaw("CASE role WHEN 'super_admin' THEN 1 WHEN 'admin' THEN 2 ELSE 3 END")
            ->orderBy('name')
            ->paginate(24)
            ->withQueryString();

        return view('cms.users.index', compact('users'));
    }

    public function create(Request $request)
    {
        return view('cms.users.create', [
            'roles' => $request->user()->assignableRoles(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', Rule::in($request->user()->assignableRoles())],
            'password' => ['nullable', Password::min(8)],
        ]);

        $typedPassword = $data['password'] ?? null;
        $password = $typedPassword ?: Str::password(16);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
            'password' => $password,
            'must_change_password' => $request->boolean('must_change_password'),
        ]);

        return redirect()->route('cms.users.index')
            ->with('success', "Account created for {$user->email}.")
            ->with('generated_password', $typedPassword ? null : $password);
    }

    public function edit(Request $request, User $user)
    {
        $this->authorizeManage($request, $user);

        return view('cms.users.edit', [
            'user' => $user,
            'roles' => $request->user()->assignableRoles(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->authorizeManage($request, $user);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'role' => ['required', Rule::in($request->user()->assignableRoles())],
            'password' => ['nullable', Password::min(8)],
        ]);

        if ($this->wouldRemoveLastSuperAdmin($user, $data['role'])) {
            return back()->withInput()->with('error', 'There must always be at least one Super Admin.');
        }

        // Nobody changes their own role — avoids locking yourself out of
        // this screen by accident.
        if ($user->is($request->user())) {
            $data['role'] = $user->role;
        }

        $user->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => $data['role'],
        ]);

        if (! empty($data['password'])) {
            $user->password = $data['password'];
            $user->must_change_password = $request->boolean('must_change_password');
        }

        $user->save();

        return redirect()->route('cms.users.index')->with('success', "Saved {$user->email}.");
    }

    public function destroy(Request $request, User $user)
    {
        $this->authorizeManage($request, $user);

        if ($user->is($request->user())) {
            return back()->with('error', 'You can\'t delete your own account.');
        }

        if ($this->wouldRemoveLastSuperAdmin($user, null)) {
            return back()->with('error', 'There must always be at least one Super Admin.');
        }

        $user->delete();

        return redirect()->route('cms.users.index')->with('success', "Removed {$user->email}.");
    }

    private function authorizeManage(Request $request, User $user): void
    {
        abort_unless($request->user()->canManage($user), 403, 'Only a Super Admin can change a Super Admin account.');
    }

    private function wouldRemoveLastSuperAdmin(User $user, ?string $newRole): bool
    {
        return $user->isSuperAdmin()
            && $newRole !== User::SUPER_ADMIN
            && User::where('role', User::SUPER_ADMIN)->count() <= 1;
    }
}
