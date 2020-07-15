<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            "first_name" => $this->first_name,
            "last_name" => $this->last_name,
            "email" => $this->email,
            "email_verified_at" => $this->email_verified_at,
            "phone" => $this->phone,
            "last_login" => $this->last_login,
            "active" => $this->active,
            "last_pass_reset_date" => $this->ilast_pass_reset_dated,
            "failed_login_count" => $this->failed_login_count,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
