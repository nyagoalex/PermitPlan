<?php

namespace App\Http\Controllers\Booking;

use App\Http\Resources\BookingGuideResource;
use App\Http\Resources\GuideResource;
use App\Models\Booking;
use App\Models\BookingGuide;
use App\Models\Guest;
use App\Models\Guide;
use App\Notifications\GuestNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BookingGuideController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Booking $booking, Guide $guide)
    {
        #insert new user
        $booking->guides()->syncWithoutDetaching($guide->id);
        return GuideResource::collection($booking->guides);
    }

    public function destroy(Request $request, Booking $booking, Guide $guide)
    {
        #insert new user
        $booking->guides()->detach($guide->id);
        return GuideResource::collection($booking->guides);
    }
}
