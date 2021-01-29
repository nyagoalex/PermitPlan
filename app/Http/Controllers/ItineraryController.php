<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItineraryRequest;
use App\Http\Resources\ItineraryPreviewResource;
use App\Http\Resources\ItineraryResource;
use App\Models\Itinerary;
use App\Traits\HelperTrait;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class ItineraryController extends Controller
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
        $order_column = $this->getOrderColumn("date");
        $query  = Itinerary::query();
        $query->when(request()->filled('active'), function ($query){
            $active = (request('active') === 'true') ? 1 : 0;
            return $query->whereActive($active);
        });
        $query->when(request()->filled('start_date'), function ($query){
            return $query->where('date', ">=", request('start_date'));
        });
        $query->when(request()->filled('end_date'), function ($query){
            return $query->where('date', "<=", request('end_date'));
        });

        $query->search(request('search'));
        $itineraries = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return ItineraryResource::collection($itineraries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItineraryRequest $request)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['ref_no'] =$this->nextNumber(Itinerary::query(), 'ref_no', 'IT');
        $itinerary = Itinerary::create($data);
        DB::commit();
        return new ItineraryResource($itinerary);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function preview($itinerary_id)
    {
        $itinerary = Itinerary::findOrFail($itinerary_id);
        $itinerary['ref'] = $itinerary->ref_no;
        $itinerary['travelers'] = 5;
        return new ItineraryPreviewResource($itinerary);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function show($itinerary_id)
    {
        $itinerary = Itinerary::findOrFail($itinerary_id);
        return new ItineraryResource($itinerary);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function update(ItineraryRequest $request, $id)
    {
        DB::beginTransaction();
        $itinerary = Itinerary::findOrFail($id);
        $data = $request->validated();
        $itinerary->update($data);
        DB::commit();
        return new ItineraryResource($itinerary);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $itinerary = Itinerary::findOrFail($id);
        $itinerary->delete();
        DB::commit();
        return new ItineraryResource($itinerary);
    }

    public function deactivate($id)
    {
        #checks if user exists
        DB::beginTransaction();
        $itinerary = Itinerary::findOrFail($id);

        // checks the current status of the user
        abort_unless($itinerary->active, Response::HTTP_BAD_REQUEST, 'itinerary already deactivated');

        #deactivation process
        $itinerary->active = false;
        $itinerary->save();
        DB::commit();
        return new ItineraryResource($itinerary);
    }

    public function activate($id)
    {
        DB::beginTransaction();
        $itinerary = Itinerary::findOrFail($id);
        // checks the current status of the user
        abort_if($itinerary->active, Response::HTTP_BAD_REQUEST, 'itinerary already active');
        #activation process
        $itinerary->active = true;
        $itinerary->save();
        DB::commit();
        return new ItineraryResource($itinerary);
    }
}
