<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermitRequest;
use App\Http\Requests\PermitTransferRequest;
use App\Http\Resources\PermitResource;
use App\Models\Booking;
use App\Models\Permit;
use App\Models\PermitTransfer;
use App\Notifications\PermitNotification;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class PermitController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($booking_id)
    {
        $bookings = Permit::whereBookingId($booking_id)->orderBy('number')->get();
        return PermitResource::collection($bookings);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermitRequest $request, $booking_id)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $booking = Booking::findOrFail($booking_id);
        $i = 1;
        $permit_numbers = [];
        while($i <= $data['no_of_permits']) {
            $data['number'] =$this->nextNumber(Permit::query(), 'number', 'PT');
            $booking->permits()->create($data);
            $i++;
            array_push($permit_numbers, $data['number']);
        }
        
        $details = "Added Permits: ". implode(", ",$permit_numbers);
        $booking->notify(new PermitNotification($booking, $details));
        DB::commit();
        return new PermitResource(Permit::whereBookingId($booking_id)->first());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function reshedule($booking_id, $permit_id)
    {
        DB::beginTransaction();
        $permit = Permit::whereBookingId($booking_id)->findOrFail($permit_id);
        $data = request()->validate(['tracking_date' => "required|date_format:Y-m-d"]);
        $data['rescheduled_from'] = $permit->tracking_date;
        $permit->update($data);

        $details = "Resheduled, Permit {$permit->number} From ". $data['rescheduled_from']." To ". $permit->tracking_date;
        $permit->booking->notify(new PermitNotification($permit, $details));
        DB::commit();
        return new PermitResource($permit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy($booking_id, $permit_id)
    {
        DB::beginTransaction();
        $permit = Permit::whereBookingId($booking_id)->findOrFail($permit_id);
        $permit->delete();

        $details = "Deleted, Permit ". $permit->number;
        $permit->booking->notify(new PermitNotification($permit, $details));
        DB::commit();
        return new PermitResource($permit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function transfer(PermitTransferRequest $request, $booking_id, $permit_id)
    {
        DB::beginTransaction();
        $permit = Permit::whereBookingId($booking_id)->findOrFail($permit_id);
        $data = $request->validated();

        abort_if($booking_id == $data['to_booking_id'], Response::HTTP_BAD_REQUEST, "Action Failed, Transfer To And From Bokkings Should Be Different");

        PermitTransfer::create([
            'to_booking_id' => $data['to_booking_id'],
            'from_booking_id' => $booking_id,
            'permit_id' => $permit_id
        ]);

        #update permit
        $permit->booking_id = $data['to_booking_id'];
        $permit->save();
        DB::commit();
        return new PermitResource($permit);
    }
}
