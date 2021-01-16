<?php

namespace App\Http\Resources\Attendance;

use App\Helpers\TimeHelper;
use App\Models\Attendance;
use App\Models\LogStatus;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GetAttendanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            'name' => $this->user->name,
            'current_status' => $this->user->latest_status,
            'over_break' => TimeHelper::minuteToStringHoursMinute((int)$this->over_break),
            'over_time' => TimeHelper::minuteToStringHoursMinute((int)$this->over_time),
            'late' => TimeHelper::minuteToStringHoursMinute((int)$this->late),
            'time_worked' => TimeHelper::minuteToStringHoursMinute((int)$this->time_worked),
            'total_bio_break' => TimeHelper::minuteToStringHoursMinute((int)$this->total_bio_break),
            'logs' => AttendanceLogResource::collection($this->getAttendanceLogs()),
        ];

        return $this->appendInAndOut($resource);
    }

    private function getAttendanceLogs()
    {
       if (!$this->isMultipleDates()) {
           return [];
       }

        $from = Carbon::parse(request()->get('from'));
        $to = Carbon::parse(request()->get('to'));

       return Attendance::query()
            ->whereBetween('in_date', [$from, $to])
            ->get();
    }

    private function isMultipleDates()
    {
        $from = Carbon::parse(request()->get('from'));
        $to = Carbon::parse(request()->get('to'));
        return $to->diffInDays($from) > 0;
    }

    private function appendInAndOut($resource)
    {
        if ($this->isMultipleDates()) {
            return array_merge($resource, [
                'in' => '-',
                'out' => '-',
            ]);
        }

        $in_date = Carbon::parse(request()->get('from'));
        $checkLogStatus = LogStatus::query()
            ->whereHas('status', function($query){
                $query->where('key', Status::CHECK_STATUS_KEY);
            })
            ->whereDate('in', $in_date)
            ->where('user_id', $this->user_id)
            ->first();

        return array_merge($resource, [
            'in' => $checkLogStatus->in ? Carbon::parse($checkLogStatus->in)->format('h:i') : '-',
            'out' => $checkLogStatus->out ? Carbon::parse($checkLogStatus->out)->format('h:i') : '-',
        ]);
    }
}
