<?php

    namespace App\Http\Controllers\Booking;

use App\Http\Resources\GuideResource;
use App\Http\Resources\VehicleResource;
use App\Models\Booking;
use App\Models\Guide;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class BookingVehicleController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Booking $booking, Vehicle $vehicle)
    {
        #insert new user
        $booking->vehicles()->syncWithoutDetaching($vehicle->id);
        return VehicleResource::collection($booking->vehicles);
    }

    public function destroy(Request $request, Booking $booking, Vehicle $vehicle)
    {
        #insert new user
        $booking->vehicles()->detach($vehicle->id);
        return VehicleResource::collection($booking->vehicles);
    }
}
