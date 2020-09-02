<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class NotificationResource extends JsonResource
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
            "id" => $this->id,
            "type" => $this->getTypeName($this->type),
            "data" => $this->data,
            "read" => !is_null($this->read_at),
            "created_at" => Carbon::parse($this->created_at)->diffForHumans()
        ];
    }

    private function getTypeName($type)
    {
        $type = str_replace("App\Notifications\\","", $type);
        $type = str_replace("Notification","", $type);
        return strtolower($type);
    }
}
