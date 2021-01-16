<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookingSingleResource extends BookingResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(
            parent::toArray($request),
            [
                'user' => $this->user->full_name,
                'agent' => ($this->agent) ? $this->agent->only('id', 'name') : null,
                "comment" => $this->comment,
                "created_at" => $this->created_at->format('D, d M Y'),
                "updated_at" => $this->updated_at->format('D, d M Y'),
                "permits" => PermitResource::collection($this->permits),
                "transfered_permits" => PermitResource::collection($this->transferedPermits),
                "payments" => PaymentResource::collection($this->payments),
                "guests" => GuestResource::collection($this->guests),
                "number_of_days" => Carbon::parse($this->departure_date)->diffInDays(Carbon::parse($this->arrival_date))
            ]
        );
    }
}
