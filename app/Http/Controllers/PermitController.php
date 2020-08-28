<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermitRequest;
use App\Http\Resources\PermitResource;
use App\Models\Permit;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $data['booking_id'] = $booking_id;

        $i = 1;
        while($i <= $data['no_of_permits']) {
            $data['number'] =$this->nextNumber(Permit::query(), 'number', 'PT');
            Permit::create($data);
            $i++;
        }
        DB::commit();
        return $this->index($booking_id);
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
        DB::commit();
        return new PermitResource($permit);
    }
}
