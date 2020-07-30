<?php

namespace App\Http\Controllers;

use App\Http\Resources\FlightTransferResource;
use App\Models\FlightTransfer;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FlightTransferController extends Controller
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
        $order_column = $this->getOrderColumn("name");
        $transfer = FlightTransfer::orderBy($order_column, $sort)->paginate($per_page);
        
        return FlightTransferResource::collection($transfer);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
          #insert new user
          DB::beginTransaction();
          $data = $this->validateData();
          $transfer = FlightTransfer::create($data);
          DB::commit();
          return new FlightTransferResource($transfer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FlightTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer = FlightTransfer::findOrFail($id);
        return new FlightTransferResource($transfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FlightTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $transfer = FlightTransfer::findOrFail($id);
        $data = $this->validateData();
        $transfer->update($data);
        DB::commit();
        return new FlightTransferResource($transfer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FlightTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $transfer = FlightTransfer::findOrFail($id);
        $transfer->delete();
        DB::commit();
        return new FlightTransferResource($transfer);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:2|max:250",
            'starting_point' => "required|string|min:2|max:250",
            'destination' => "required|string|min:2|max:250",
            'airline_operator' => "nullable|string|min:2|max:250",
            'cost_per_person' => ['required', 'numeric', 'min:0', 'max:999999999999999999999'],
            'distance' => ['required', 'numeric', 'min:0', 'max:9999999999999'],
            'est_time' => ['required', 'date_format:H:i'],
            'departure_time' => ['required', 'date_format:H:i'],
            'arrival_time' => ['required', 'date_format:H:i'],
            'flight_type' => ['required', 'in:scheduled,chartered']
        ]);
    }
}
