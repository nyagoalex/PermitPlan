<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryPreview extends JsonResource
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
            'total_cost' => $this->total_cost,
            "summary" => $this->summary->all(),
            "stays" => $this->stays->toArray(),
            "days" => $this->days
        ];
    }
}
