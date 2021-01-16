<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Attendance\GetAttendanceResource;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->all();
        $from = Carbon::parse($params['from']);
        $to = Carbon::parse($params['to']);

        $attendances = Attendance::query()
            ->select([
                'user_id',
                \Illuminate\Support\Facades\DB::raw('SUM(over_break) AS over_break'),
                \Illuminate\Support\Facades\DB::raw('SUM(over_time) AS over_time'),
                \Illuminate\Support\Facades\DB::raw('SUM(late) AS late'),
                \Illuminate\Support\Facades\DB::raw('SUM(time_worked) AS time_worked'),
                \Illuminate\Support\Facades\DB::raw('SUM(total_bio_break) AS total_bio_break'),
            ])
            ->whereBetween('in_date', [$from, $to])
            ->when(isset($params['id']), function ($query) use ($params){
                $query->whereIn('user_id', $params['id']);
            })
            ->when(isset($params['team_id']), function ($query) use ($params){
                $query->whereHas('user', function ($query) use ($params){
                    $query->where('team_id', $params['team_id']);
                });
            })
            ->groupBy('user_id')
            ->paginate($params['limit']);

        $sBaseUrl =  config('env.url.api') . '/attendances?' . http_build_query($params);
        $attendances->withPath($sBaseUrl);

        return GetAttendanceResource::collection($attendances);
    }
}
