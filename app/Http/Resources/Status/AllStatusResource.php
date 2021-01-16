<?php

namespace App\Http\Resources\Status;

use Illuminate\Http\Resources\Json\JsonResource;

class AllStatusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'key' => $this->key,
            'number' => $this->number,
        ];
    }
}
