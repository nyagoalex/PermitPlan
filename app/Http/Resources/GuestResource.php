<?php

namespace App\Http\Resources;

use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class GuestResource extends JsonResource
{
    use HelperTrait;
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
            "age" => $this->getAge($this->dob),
            "nationality" => $this->nationality,
            "passport" => $this->passport,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
            "payments" => []
        ];
    }
}
