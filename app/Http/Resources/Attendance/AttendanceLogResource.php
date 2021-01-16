<?php

namespace App\Http\Resources\Attendance;

use App\Helpers\TimeHelper;
use App\Models\LogStatus;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceLogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $in_date = Carbon::parse($this->in_date);
        $checkLogStatus = LogStatus::query()
            ->whereHas('status', function($query){
                $query->where('key', Status::CHECK_STATUS_KEY);
            })
            ->whereDate('in', $in_date)
            ->where('user_id', $this->user_id)
            ->first();

        return [
            'date' => $in_date->format('F d, Y'),
            'over_break' => TimeHelper::minuteToStringHoursMinute((int)$this->over_break),
            'over_time' => TimeHelper::minuteToStringHoursMinute((int)$this->over_time),
            'late' => TimeHelper::minuteToStringHoursMinute((int)$this->late),
            'time_worked' => TimeHelper::minuteToStringHoursMinute((int)$this->time_worked),
            'total_bio_break' => TimeHelper::minuteToStringHoursMinute((int)$this->total_bio_break),
            'in' => $checkLogStatus->in ? Carbon::parse($checkLogStatus->in)->format('h:i') : '-',
            'out' => $checkLogStatus->out ? Carbon::parse($checkLogStatus->out)->format('h:i') : '-',
        ];
    }
}
