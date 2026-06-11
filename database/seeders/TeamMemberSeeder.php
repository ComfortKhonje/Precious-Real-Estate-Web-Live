<?php

namespace Database\Seeders;

use App\Models\TeamMember;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamMemberSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $teamMembers = [
            [
                'name' => 'Precious Tembo',
                'role' => 'Managing Director',
                'bio' => 'Leads the business strategy and client engagement for high-value property transactions.',
                'photo_url' => '',
                'order' => 1,
                'visible' => true,
            ],
            [
                'name' => 'Ronald Mosopa',
                'role' => 'Valuation Officer',
                'bio' => 'Delivers independent valuations grounded in local market knowledge and regulatory compliance.',
                'photo_url' => '',
                'order' => 2,
                'visible' => true,
            ],
            [
                'name' => 'Doreen Mpunga',
                'role' => 'ICT & Compliance Officer',
                'bio' => 'Ensures secure systems and compliance across all client and property records.',
                'photo_url' => '',
                'order' => 3,
                'visible' => true,
            ],
            [
                'name' => 'Happy Tembo',
                'role' => 'Records Officer',
                'bio' => 'Manages documentation and client files to keep property processes organised and reliable.',
                'photo_url' => '',
                'order' => 4,
                'visible' => true,
            ],
            [
                'name' => 'Andrew Mahuka',
                'role' => 'Valuation Officer',
                'bio' => 'Supports market research and property inspections for accurate valuations.',
                'photo_url' => '',
                'order' => 5,
                'visible' => true,
            ],
        ];

        foreach ($teamMembers as $member) {
            TeamMember::updateOrCreate(
                ['name' => $member['name']],
                $member
            );
        }
    }
}
