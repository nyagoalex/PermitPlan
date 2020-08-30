<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermitRequest;
use App\Http\Resources\DepartureTourPermitResource;
use App\Models\Booking;
use App\Models\DepartureTourPermit;
use App\Models\Permit;
use App\Traits\HelperTrait;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DepartureTourPermitController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tour_id)
    {
        $permits = DepartureTourPermit::whereGroupTourId($tour_id)->orderBy('number')->get();
        return DepartureTourPermitResource::collection($permits);
    }

       /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermitRequest $request, $tour_id)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['group_tour_id'] = $tour_id;

        $i = 1;
        while($i <= $data['no_of_permits']) {
            $data['number'] =$this->nextNumber(DepartureTourPermit::query(), 'number', 'DPT');
            $permit = DepartureTourPermit::create($data);
            $i++;
        }
        DB::commit();
        return new DepartureTourPermitResource($permit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function reshedule($tour_id, $permit_id)
    {
        DB::beginTransaction();
        $permit = DepartureTourPermit::whereGroupTourId($tour_id)->findOrFail($permit_id);
        abort_if($permit->allocated, Response::HTTP_BAD_REQUEST, 'Action Failed, Permit Already Allocated');
        $data = request()->validate(['tracking_date' => "required|date_format:Y-m-d"]);
        $data['rescheduled_from'] = $permit->tracking_date;
        $permit->update($data);
        DB::commit();
        return new DepartureTourPermitResource($permit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function destroy($tour_id, $permit_id)
    {
        DB::beginTransaction();
        $permit = DepartureTourPermit::whereGroupTourId($tour_id)->findOrFail($permit_id);
         // checks the current status of the user
         abort_if($permit->allocated, Response::HTTP_BAD_REQUEST, 'Action Failed, Permit Already Allocated');
        $permit->delete();
        DB::commit();
        return new DepartureTourPermitResource($permit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permit  $permit
     * @return \Illuminate\Http\Response
     */
    public function allocate($tour_id, $permit_id)
    {
        DB::beginTransaction();
        $departure_permit = DepartureTourPermit::whereGroupTourId($tour_id)->findOrFail($permit_id);
         // checks the current status of the user
        abort_if($departure_permit->allocated, Response::HTTP_BAD_REQUEST, 'Action Failed, Permit Already Allocated');
        $data = request()->validate(['booking_id' => "required|exists:bookings,id"]);

        $booking_id = $data['booking_id'];
        $booking = Booking::findOrFail($booking_id);
        abort_if($booking->cancelled, Response::HTTP_BAD_REQUEST, 'Booking Chosen was Cancelled');

        $new_permit_data = $departure_permit->only('permit_type_id','sector_id', 'cost', 'tracking_date', 'rescheduled_from');
        $new_permit_data['group_tour_id'] = $tour_id;
        $new_permit_data['booking_id'] = $booking_id;
        $new_permit_data['number'] = $this->nextNumber(Permit::query(), 'number', 'PT');

        $new_permit = Permit::create($new_permit_data);
        $departure_permit->allocated_permit_id = $new_permit->id;
        $departure_permit->save();
        
        DB::commit();
        return new DepartureTourPermitResource($departure_permit);
    }
}
