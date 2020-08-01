<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RoadTransferResource extends JsonResource
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
            'starting_point' => $this->starting_point,
            'destination' => $this->destination,
            'vehicle_id' => $this->vehicle_id,
            'cost_per_person' => $this->cost_per_person,
            'est_time' => $this->est_time,
            'distance' => $this->distance,
            'vehicle' => $this->vehicle->only('code', 'type')
        ];
    }
}
