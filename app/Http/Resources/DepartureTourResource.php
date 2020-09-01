<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartureTourResource extends JsonResource
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
            "name" => $this->name,
            "arrival_date" => $this->arrival_date,
            "departure_date" => $this->departure_date,
            'user' => $this->user->full_name,
            "active" => $this->active,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
            "permits" => DepartureTourPermitResource::collection($this->permits),
            "permits_count" => $this->permits_count,
            "deletable" => $this->deletable,
        ];
    }
}
