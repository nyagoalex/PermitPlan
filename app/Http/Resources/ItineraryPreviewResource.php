<?php

namespace App\Http\Resources;

use App\Models\Lodge;
use Illuminate\Http\Resources\Json\JsonResource;

class ItineraryPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $days = $this->getDays($this->days);
        return [
            'id' => $this->id,
            'total_cost' => $this->total_cost,
            "ref" => $this->ref,
            "travelers" => $this->travelers,
            "summary" => $days->get('summary'),
            "stays" => $days->get('stays'),
            "days" => $days->get('days'),
            "photos" => $days->get('photos'),
        ];
    }

    private function getDays($days)
    {
        $stays = collect([]);
        $photos = collect([]);
        $acc_cost = $act_cost = $r_trans_cost = $f_trans_cost = 0;
        foreach ($days as $day) {
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

        return collect([
            'summary' => $summary->all(),
            'stays' => $stays,
            'days' => $days,
            'photos' => $photos->collapse()->unique()->shuffle()->take(10)
        ]);
        
    }
}
