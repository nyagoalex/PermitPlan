<?php

namespace App\Http\Resources;

use App\Traits\HelperTrait;
use Illuminate\Http\Resources\Json\JsonResource;

class GuideResource extends JsonResource
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
            "code" => $this->code,
            "dob" => $this->dob,
            "experience_since" => $this->experience_since,
            "email" => $this->email,
            "phone" => $this->phone,
            "contract_basis" => $this->contract_basis,
            "status" => $this->status,
            "cost_per_day" => $this->cost_per_day,
            "parks_experience" => $this->parks_experience,
            "vehicle_types_experience" => $this->vehicle_types_experience,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "full_name" => $this->full_name,
            "age" => $this->getAge($this->dob),
            "experience" => $this->getAge($this->experience_since),
        ];
    }
}
