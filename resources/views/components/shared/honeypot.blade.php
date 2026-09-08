{{--
    Spam trap: a real, focusable text input (not type="hidden" or
    display:none — some bots skip those) named to look worth filling in,
    but visually off-screen and hidden from assistive tech. A human never
    sees or fills it; a bot that blindly fills every field does. The
    matching server-side check (both public API controllers) silently
    returns the normal success response without creating a row or sending
    mail whenever this field is non-empty — no error shown, so an
    adaptive bot doesn't learn which field gave it away.

    Deliberately plain HTML, no x-model — the forms that use this each
    name their Alpine state differently (formData, form, etc.), so instead
    each submit() reads this field straight off the DOM
    (document.querySelector('input[name="website"]')) right before
    building its request payload. Keeps this partial reusable anywhere
    without needing to match a specific Alpine variable name.
--}}
<div class="absolute -left-[9999px] w-px h-px overflow-hidden" aria-hidden="true">
    <label>
        Leave this field blank
        <input type="text" name="website" tabindex="-1" autocomplete="off">
    </label>
</div>
