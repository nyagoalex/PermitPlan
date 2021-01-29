<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItineraryRequest;
use App\Http\Resources\ItineraryPreview;
use App\Http\Resources\ItineraryResource;
use App\Models\Booking;
use App\Models\Itinerary;
use App\Models\Lodge;
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
        $booking = Booking::findOrFail($itinerary_id);
        $acc_cost = $act_cost = $r_trans_cost = $f_trans_cost = 0;

        $stays = collect([]);
        $days = $booking->itinerary->days;
        $photos = collect([]);
        foreach ($days as $day) {
            // dd($day->priority);
            $stays_day = [
                'period' => 'Day '. $day->priority  .' - Day '.(int)($day->priority + 1),
                'items' => []
            ];
            foreach ($day->items as $item) {
                if ($item->type == "accomodation") {
                    $acc_cost += $item->cost;
                    $temp = $item;
                    $model = Lodge:: findOrFail($item->type_id);
                    $lodge_photos = $model->photos->pluck('name');
                    $temp->name = $model->name;
                    $temp->country = $model->country;
                    $temp->location = $model->location;
                    $temp->photos = $lodge_photos;
                    $temp = collect($temp)->only('duration', 'children', 'adults', "name" ,"country","location","photos");
                    array_push($stays_day['items'], $temp);
                    $photos->push($lodge_photos->all());
                }
                if ($item->type == "activities") {
                    $act_cost += $item->cost;
                }
                if ($item->type == "flight transfer") {
                    $f_trans_cost += $item->cost;
                }
                if ($item->type == "road transfer") {
                    $r_trans_cost += $item->cost;
                }
            }
            $stays->push($stays_day);
        }
        $summary = collect([
            ['type' => 'accomodation', 'cost' => $acc_cost],
            ['type' => 'activities', 'cost' => $act_cost],
            ['type' => 'road transfer', 'cost' => $r_trans_cost],
            ['type' => 'flight transfer', 'cost' => $f_trans_cost]
        ])->sortByDesc(function ($item) {
            return $item['cost'];
        });
        
        $booking['ref'] = $booking->ref;
        $booking['travelers'] = $booking->no_of_persons;
        $booking['summary'] = $summary;
        $booking['stays'] = $stays;
        $booking['days'] = $days;
        $booking['photos'] = $photos->collapse()->unique()->shuffle()->take(10);
        return new ItineraryPreview($booking);
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
