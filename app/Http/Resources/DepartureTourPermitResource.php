<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class DepartureTourPermitResource extends JsonResource
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
            "permit_type_name" => str_replace('permits', '', str_replace('_', ' ',ucfirst($this->permitType->name))),
            "sector" => $this->sector->name,
            "number" => $this->number,
            "cost" => $this->cost,
            "tracking_date" => $this->tracking_date,
            "rescheduled" => $this->rescheduled,
            "rescheduled_from" =>Carbon::parse($this->rescheduled_from)->format('D, d M Y'),
            "tracking_date_format" => Carbon::parse($this->tracking_date)->format('D, d M Y'),
            "allocated" => $this->allocated,
            "allocated_to" => ($this->allocated) ? 'Permit:'.$this->allocatedTo->number.' On Booking:'.$this->allocatedTo->Booking->number : null
        ];
    }
}
