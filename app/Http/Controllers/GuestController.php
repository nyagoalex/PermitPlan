<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\Guest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($booking_id)
    {
        $guests = Guest::whereBookingId($booking_id)->get();
        return GuestResource::collection($guests);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestRequest $request, $booking_id)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['booking_id'] = $booking_id;
        $guest = Guest::create($data);
        DB::commit();
        return new GuestResource($guest);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(GuestRequest $request, $booking_id, $guest_id)
    {
        DB::beginTransaction();
        $guest = Guest::whereBookingId($booking_id)->findOrFail($guest_id);
        $data = $request->validated();
        $guest->update($data);
        DB::commit();
        return new GuestResource($guest);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking_id, $guest_id)
    {
        DB::beginTransaction();
        $guest = Guest::whereBookingId($booking_id)->findOrFail($guest_id);
        $guest->delete();
        DB::commit();
        return new GuestResource($guest);
    }
}
