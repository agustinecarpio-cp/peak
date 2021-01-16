<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = [
            'id' => 1,
            'employee_id' => 'PEAK00001',
            'name' => 'Admin',
            'birthday' => '1990-01-02',
            'username' => 'admin',
            'email' => 'admin@sample.com',
            'password' => Hash::make('peak123'),
            'shift_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        \App\Models\User::query()->create($admin);

        $teamLeader = [
            'id' => 2,
            'employee_id' => 'PEAK00002',
            'name' => 'Team Leader',
            'birthday' => '1991-05-02',
            'username' => 'team_leader',
            'email' => 'team_leader@sample.com',
            'password' => Hash::make('peak123'),
            'shift_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        \App\Models\User::query()->create($teamLeader);

        $team = [
            'id' => 1,
            'lead_id' => 2,
            'name' => 'Developer Team',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        \App\Models\Team::query()->create($team);

        $agents = [
            [
                'id' => 3,
                'employee_id' => 'PEAK00003',
                'name' => 'First Agent',
                'birthday' => '1992-05-02',
                'username' => 'first_agent',
                'email' => 'first_agent@sample.com',
                'password' => Hash::make('peak123'),
                'shift_id' => 1,
                'team_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 4,
                'employee_id' => 'PEAK00004',
                'name' => 'Second Agent',
                'birthday' => '1993-05-02',
                'username' => 'second_agent',
                'email' => 'second_agent@sample.com',
                'password' => Hash::make('peak123'),
                'shift_id' => 1,
                'team_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id' => 5,
                'employee_id' => 'PEAK00005',
                'name' => 'Third Agent',
                'birthday' => '1994-05-02',
                'username' => 'third_agent',
                'email' => 'third_agent@sample.com',
                'password' => Hash::make('peak123'),
                'shift_id' => 1,
                'team_id' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        foreach ($agents as $agent) {
            \App\Models\User::query()->create($agent);
        }

        // assign role
        $admin = \App\Models\User::query()->find(1);
        $admin->assignRole('Admin');

        $teamLeader = \App\Models\User::query()->find(2);
        $teamLeader->assignRole('Team Leader');
        $teamLeader->team_id = 1;
        $teamLeader->save();

        $agents = \App\Models\User::query()->whereIn('id', [3,4,5])->get();
        foreach ($agents as $agent) {
            $agent->assignRole('Agent');
        }
    }
}
