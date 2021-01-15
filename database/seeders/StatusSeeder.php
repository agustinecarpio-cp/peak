<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'name' => 'Check',
                'key' => 'check',
                'number' => 1,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Bio Break',
                'key' => 'bio_break',
                'number' => 2,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'team_meeting',
                'key' => 'Team Meeting',
                'number' => 3,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Coaching',
                'key' => 'coaching',
                'number' => 4,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Training',
                'key' => 'training',
                'number' => 5,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Break',
                'key' => 'break',
                'number' => 6,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Lunch',
                'key' => 'lunch',
                'number' => 7,
                'in_allowance' => 15,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($statuses as $status) {
            \App\Models\Status::query()->create($status);
        }
    }
}
