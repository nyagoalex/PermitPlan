<?php

namespace App\Http\Controllers;

use App\Http\Requests\GuestRequest;
use App\Http\Resources\GuestResource;
use App\Models\Guest;
use App\Notifications\GuestNotification;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuestController extends Controller
{
    use HelperTrait;
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

        $details = "Added Guest ".$guest->fullName." Of ".$this->getAge($guest->dob)."old";
        $guest->booking->notify(new GuestNotification($guest, $details));
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

        $details = "Udated Guest ".$guest->fullName."'s Details";
        $guest->booking->notify(new GuestNotification($guest, $details));
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

        $details = "Deleted Guest ".$guest->fullName;
        $guest->booking->notify(new GuestNotification($guest, $details));
        DB::commit();
        return new GuestResource($guest);
    }
}
