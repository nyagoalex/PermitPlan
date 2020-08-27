<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sort = $this->getSort();
        $per_page = $this->getPerPage();
        $order_column = $this->getOrderColumn("number");
        $query  = Booking::query();
        $query->when(request()->filled('status'), function ($query){
            return $query->whereStatus(request('status'));
        });
        $query->search(request('search'));
        $bookings = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return BookingResource::collection($bookings);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BookingRequest $request)
    {
        #insert new booking
        DB::beginTransaction();
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $booking = Booking::create($data);
        DB::commit();
        return new BookingResource($booking);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show($booking_id)
    {
        $booking = Booking::with('permits')->findOrFail($booking_id);
        return new BookingResource($booking);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(BookingRequest $request, $booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::findOrFail($booking_id);
        $data = $request->validated();
        $booking->update($data);
        DB::commit();
        return new BookingResource($booking);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::findOrFail($booking_id);
        $booking->delete();
        DB::commit();
        return new BookingResource($booking);
    }


    public function cancel($booking_id)
    {
        #checks if user exists
        DB::beginTransaction();
        $booking = Booking::findOrFail($booking_id);

        // checks the current status of the user
        abort_unless($booking->tentative, Response::HTTP_BAD_REQUEST, 'Booking status not tentative');

        #deactivation process
        $booking->status = 'cancelled';
        $booking->save();
        DB::commit();
        return new BookingResource($booking);
    }

    public function confirm($booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::findOrFail($booking_id);
        // checks the current status of the user
        abort_unless($booking->tentative, Response::HTTP_BAD_REQUEST, 'Booking status not tentative');
        #activation process
        $booking->status = 'confirmed';
        $booking->save();
        DB::commit();
        return new BookingResource($booking);
    }

    public function comment($booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::findOrFail($booking_id);
        $data = request()->validate(['comment' => "nullable|string"]);
        $booking->update($data);
        DB::commit();
        return new BookingResource($booking);
    }
}
