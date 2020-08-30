<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Http\Resources\BookingResource;
use App\Http\Resources\BookingSingleResource;
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

        $query->when(request()->filled('source'), function ($query){
            if (request('source') == 'agent') {
                return $query->whereNotNull('agent_id');
            }
            if (request('source') == 'direct') {
                return $query->whereNull('agent_id');
            }
        });

        $query->when(request()->filled('payment_status'), function ($query){
            $sql = "(select IFNULL(sum(amount),0) from payments where booking_id = bookings.id)";
            if (request('payment_status') == 'cleared') {
                return $query->whereRaw($sql."  <= 0");
            }
            if (request('payment_status') == 'outstanding') {
                return $query->whereRaw($sql." > 0");
            }
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
        DB::beginTransaction();
        $data = $request->validated();
        $data['number'] =$this->nextNumber(Booking::query(), 'number', 'B');
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
        $booking = Booking::with('permits', 'permits.permitType', 'permits.sector', 'user', 'agent', 'payments', 'payments.user', 'guests')->findOrFail($booking_id);
        return new BookingSingleResource($booking);
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
        $booking = Booking::with('permits', 'permits.permitType', 'permits.sector', 'user', 'agent', 'payments', 'payments.user', 'guests')->findOrFail($booking_id);

        // checks the current status of the user
        abort_unless($booking->tentative, Response::HTTP_BAD_REQUEST, 'Booking status not tentative');

        #deactivation process
        $booking->status = 'cancelled';
        $booking->save();
        DB::commit();
        return new BookingSingleResource($booking);
    }

    public function confirm($booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::with('permits', 'permits.permitType', 'permits.sector', 'user', 'agent', 'payments', 'payments.user', 'guests')->findOrFail($booking_id);
        // checks the current status of the user
        abort_unless($booking->tentative, Response::HTTP_BAD_REQUEST, 'Booking status not tentative');
        #activation process
        $booking->status = 'confirmed';
        $booking->save();
        DB::commit();
        return new BookingSingleResource($booking);
    }

    public function comment($booking_id)
    {
        DB::beginTransaction();
        $booking = Booking::with('permits', 'permits.permitType', 'permits.sector', 'user', 'agent', 'payments', 'payments.user', 'guests')->findOrFail($booking_id);
        $data = request()->validate(['comment' => "nullable|string"]);
        $booking->update($data);
        DB::commit();
        return new BookingSingleResource($booking);
    }
}
