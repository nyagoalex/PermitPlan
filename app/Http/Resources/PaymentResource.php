<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            "date" => Carbon::parse($this->date)->format('D, d M Y'),
            "user" => $this->user->fullname,
            "method" => $this->method,
            "cheque_no" => $this->cheque_no,
            "ref_no" => $this->ref_no,
        ];
    }
}
