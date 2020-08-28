<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
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
            "number" => $this->number,
            "ref" => $this->ref,
            'source' => $this->source,
            "status" => $this->status,
            'no_of_persons' => $this->no_of_persons,
            'cost_per_person' => $this->cost_per_person,
            "arrival_date" => $this->arrival_date,
            "departure_date" => $this->departure_date,
            "client_name" => $this->client_name,
            "permits_count" => $this->permits_count,
            "total_cost" => $this->total_cost,
            "total_paid" => $this->total_paid,
            "balance" => $this->balance,
        ];
    }
}