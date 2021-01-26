<?php

namespace App\Http\Controllers;

use App\Http\Resources\ItineraryResource;
use App\Models\Booking;
use App\Models\Itinerary;
use App\Models\Lodge;
use Illuminate\Http\Request;

class ItineraryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function show($itinerary_id)
    {
        $booking = Booking::findOrFail($itinerary_id);
        $acc_cost = $act_cost = $r_trans_cost = $f_trans_cost = 0;

        $stays = collect([]);
        $days = $booking->itinerary->days;
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
                    $temp->name = $model->name;
                    $temp->country = $model->country;
                    $temp->location = $model->location;
                    $temp->photos = $model->photos->pluck('name');
                    $temp = collect($temp)->only('duration', 'children', 'adults', "name" ,"country","location","photos");
                    array_push($stays_day['items'], $temp);

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

        $booking['summary'] = $summary;
        $booking['stays'] = $stays;
        $booking['days'] = $days;
        // dd(count($days));
        return new ItineraryResource($booking);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Itinerary $itinerary)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Itinerary  $itinerary
     * @return \Illuminate\Http\Response
     */
    public function destroy(Itinerary $itinerary)
    {
        //
    }
}
