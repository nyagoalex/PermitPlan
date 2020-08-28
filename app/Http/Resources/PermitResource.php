<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PermitResource extends JsonResource
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
            "permit_type" => $this->permitType->only("id", "name"),
            "sector" => $this->sector->only("id", "name"),
            "number" => $this->number,
            "cost" => $this->cost,
            "tracking_date" => $this->tracking_date,
            "rescheduled" => $this->rescheduled,
            "rescheduled_from" => $this->rescheduled_from,
            "expired" => $this->expired,
            "expired_date" => $this->expired_date,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
        ];
    }
}
