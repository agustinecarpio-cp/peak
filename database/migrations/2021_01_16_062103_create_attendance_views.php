<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendanceViews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \Illuminate\Support\Facades\DB::statement($this->createView());
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \Illuminate\Support\Facades\DB::statement($this->dropView());
    }

    private function createView()
    {
        $breaktimeKey = \App\Models\Status::BREAKTIME_STATUS_KEY;
        $checkKey = \App\Models\Status::CHECK_STATUS_KEY;
        $bioBreakKey = \App\Models\Status::BIOBREAK_STATUS_KEY;
        return "CREATE OR REPLACE VIEW `attendances` AS SELECT ls.user_id AS user_id, DATE(`in`) as in_date,
                SUM(IF(s.key = '$breaktimeKey' AND `out` IS NOT NULL AND expected_out IS NOT NULL, (TIME_TO_SEC(TIMEDIFF(`out`, expected_out)) / 60), 0)) AS over_break,
                SUM(IF(s.key = '$checkKey' AND `out` IS NOT NULL AND expected_out IS NOT NULL, (TIME_TO_SEC(TIMEDIFF(`out`, expected_out)) / 60), 0)) AS over_time,
                SUM(IF(s.key = '$checkKey' AND expected_in IS NOT NULL, (TIME_TO_SEC(TIMEDIFF(`in`, expected_in)) / 60), 0)) AS late,
                SUM(IF(s.key = '$checkKey' AND `out` IS NOT NULL AND expected_out IS NOT NULL, (TIME_TO_SEC(TIMEDIFF(`out`, `in`)) / 60), 0)) AS time_worked,
                SUM(IF(s.key = '$bioBreakKey' AND `out` IS NOT NULL, (TIME_TO_SEC(TIMEDIFF(`out`, `in`)) / 60), 0)) AS total_bio_break
                FROM log_statuses ls
                INNER JOIN statuses s ON s.id = ls.status_id
                GROUP BY user_id, in_date
                ";
    }

    private function dropView()
    {
        return "DROP VIEW IF EXISTS `attendances`";
    }
}
