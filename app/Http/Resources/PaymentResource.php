<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
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
            "amount" => $this->amount,
            "date" => $this->date,
            "user" => $this->user->only("id", "fullname"),
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
        ];
    }
}
