<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SingleLodgeResource extends JsonResource
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
            "code" => $this->code,
            "name" => $this->name,
            "star_rating" => $this->star_rating,
            "contracted_rating" => $this->contracted_rating,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "country" => $this->country,
            "location" => $this->location,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "rooms" =>  $this->rooms,
            "seasons" => $this->seasons->map(function ($season) { return $season->only('id', 'name', 'from_date', 'to_date');}),
            "activities" => $this->activities->map(function ($activity) { return $activity->only('id', 'name', 'cost_per_person'); }),
            "facilities" => $this->facilities->map(function ($facility) { return $facility->only('id', 'name', 'cost_per_person'); }),
            // "room_costs" => $this->roomCosts
        ];
    }
}
