<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
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
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "full_name" => $this->full_name,
            "dob" => $this->dob,
            "nationality" => $this->nationality,
            "passport" => $this->passport,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
        ];
    }
}
