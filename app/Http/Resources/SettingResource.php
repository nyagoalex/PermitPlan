<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            "company_name" => $this->company_name,
            "physical_address" => $this->physical_address,
            "permit_expiry_in_days" => $this->permit_expiry_in_days,
            "registration_no" => $this->registration_no,
            "email" => $this->email,
            "phone" => $this->phone,
            "website" => $this->website,
            "logo" => $this->logo,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
        ];
    }
}
