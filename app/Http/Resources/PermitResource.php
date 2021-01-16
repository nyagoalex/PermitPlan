<?php

namespace App\Http\Resources;

use Illuminate\Support\Str;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class PermitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {//Str::of($this->permitType->name)->replace('_', ' '),
        return [
            "id" => $this->id,
            "permit_type_name" => str_replace('permits', '', str_replace('_', ' ',ucfirst($this->permitType->name))),
            "sector" => $this->sector->name,
            "number" => $this->number,
            "cost" => $this->cost,
            "tracking_date" => $this->tracking_date,
            "rescheduled" => $this->rescheduled,
            "rescheduled_from" =>Carbon::parse($this->rescheduled_from)->format('D, d M Y'),
            "expired" => $this->expired,
            "expired_date" =>  ($this->expired_date) ? Carbon::parse($this->expired_date)->format('D, d M Y') : null,
            "created_at" => $this->created_at->format('D, d M Y'),
            "updated_at" => $this->updated_at->format('D, d M Y'),
            "tracking_date_format" => Carbon::parse($this->tracking_date)->format('D, d M Y'),
            "payments" => PaymentResource::collection($this->payments),
            "balance" => $this->balance,
            "payment_status" => $this->payment_status,
            'booking' => $this->booking->only('id', 'number', 'ref')
        ];
    }
}
