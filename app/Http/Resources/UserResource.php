<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class UserResource extends JsonResource
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
            "full_name" => $this->full_name,
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "email_verified_at" => $this->email_verified_at,
            "phone" => $this->phone,
            "last_login" => is_null($this->last_login) ? 'never' : Carbon::parse($this->last_login)->diffForHumans() ,
            "active" => $this->active,
            "last_pass_reset_date" => $this->ilast_pass_reset_dated,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
            "created_since" => Carbon::parse($this->created_at)->diffForHumans(),
            "role" => 'administrator',
        ];
    }
}
