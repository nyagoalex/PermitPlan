<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PermitResource;
use App\Models\Booking;
use App\Models\Payment;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends Controller
{
  /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($booking_id)
    {
        $payments = Payment::whereBookingId($booking_id)->get();
        return PaymentResource::collection($payments);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequest $request, $booking_id)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $booking = Booking::findOrFail($booking_id);
        // do not pay beyond the balance
        abort_if($data['amount'] > $booking->balance, Response::HTTP_BAD_REQUEST, "Action Failed, Booking Over Payment Amount:{$data['amount']} Bal:{$booking->balance}");
        $payment = $booking->payments()->create($data);

        $booking->refresh();
        $details = "Made Payment Of ".$data['amount'].", New Booking Balance Is ".$booking->balance;
        $booking->notify(new PaymentNotification($payment, $details));
        DB::commit();
        return new PaymentResource($payment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking_id, $payment_id)
    {
        DB::beginTransaction();
        $payment = Payment::whereBookingId($booking_id)->findOrFail($payment_id);
        $payment->delete();

        $booking = $payment->booking;
        $details = "Deleted Payment Of ".$payment->amount." New Booking Balance Is ".$booking->balance;
        $booking->notify(new PaymentNotification($payment, $details));
        DB::commit();
        return new PaymentResource($payment);
    }
}
