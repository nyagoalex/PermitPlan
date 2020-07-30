<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoadTransferResource;
use App\Models\RoadTransfer;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoadTransferController extends Controller
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
        $transfer = RoadTransfer::orderBy($order_column, $sort)->paginate($per_page);
        
        return RoadTransferResource::collection($transfer);
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
          $transfer = RoadTransfer::create($data);
          DB::commit();
          return new RoadTransferResource($transfer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RoadTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transfer = RoadTransfer::findOrFail($id);
        return new RoadTransferResource($transfer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RoadTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $transfer = RoadTransfer::findOrFail($id);
        $data = $this->validateData();
        $transfer->update($data);
        DB::commit();
        return new RoadTransferResource($transfer);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RoadTransfer  $roadTransfer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $transfer = RoadTransfer::findOrFail($id);
        $transfer->delete();
        DB::commit();
        return new RoadTransferResource($transfer);
    }

    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:2|max:250",
            'starting_point' => "required|string|min:2|max:250",
            'destination' => "required|string|min:2|max:250",
            'vehicle_id' => "required|exists:vehicles,id",
            'cost_per_person' => ['required', 'numeric', 'min:0', 'max:999999999999999999999'],
            'distance' => ['required', 'numeric', 'min:0', 'max:9999999999999'],
            'est_time' => ['required', 'date_format:H:i'],
        ]);
    }
}