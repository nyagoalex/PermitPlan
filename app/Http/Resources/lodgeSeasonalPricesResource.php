<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class lodgeSeasonalPricesResource extends JsonResource
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
            "code" => $this->code,
            "name" => $this->name,
            "star_rating" => $this->star_rating,
            "contracted_rating" => $this->contracted_rating,
            "email" => $this->email,
            "phone" => $this->phone,
            "address" => $this->address,
            "country" => $this->country,
            "location" => $this->location,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "seasonal_prices" =>  $this->seasonalPrices()
        ];
    }

    private function seasonalPrices()
    {
        $date = request('date', today()->format('Y-m-d'));
        $lodge = $this;
        $season = $lodge->seasons()->with('roomCosts', 'roomCosts.room')->whereRaw("from_date <= '{$date}' and to_date >= '{$date}'")->first();

        if (!$season){
            $season = $lodge->seasons()->with('roomCosts', 'roomCosts.room')->whereRaw("to_date <= '{$date}'")->first();
        }

        if (!$season) {
            return null;
        }
        $seasonal_prices = $season->roomCosts;
        $seasonal_prices->transform(function($value) {
            $item = $value->only('room_id', 'amount');
            $item['room_name'] = $value->room->name;
            $item['qty'] = 0;
            $item['selected'] = false;
            return $item;
        });
        return $seasonal_prices;
    }
}