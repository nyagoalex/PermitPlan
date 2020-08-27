<?php

namespace App\Http\Controllers;

use App\Http\Requests\PaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Http\Resources\PermitResource;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $data['booking_id'] = $booking_id;
        $data['user_id'] = Auth::id();
        $payment = Payment::create($data);
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
        DB::commit();
        return new PaymentResource($payment);
    }
}
