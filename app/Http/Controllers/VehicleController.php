<?php

namespace App\Http\Controllers;

use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
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
        $order_column = $this->getOrderColumn("code");
        $query = Vehicle::query();
        $query->when(request()->filled('status'), function ($query){
            return $query->whereStatus(request('status'));
        });
        $query->when(request()->filled('ownership'), function ($query){
            return $query->whereOwnership(request('ownership'));
        });
        $query->search(request('search'));
        $vehicle = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return VehicleResource::collection($vehicle);
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
        $vehicle = Vehicle::create($data);
        DB::commit();
        return new VehicleResource($vehicle);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return new VehicleResource($vehicle);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $vehicle = Vehicle::findOrFail($id);
        $data = $this->validateData();
        $vehicle->update($data);
        DB::commit();
        return new VehicleResource($vehicle);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        DB::commit();
        return new VehicleResource($vehicle);
    }

    private function validateData()
    {
        $request = Request();
        $unique_code = $request->isMethod('post') ? 'unique:vehicles' : "unique:vehicles,code,". $request->route('vehicle_id');
        $unique_reg_no = $request->isMethod('post') ? 'unique:vehicles' : "unique:vehicles,reg_no,". $request->route('vehicle_id');
        
        return $request->validate([
            'reg_no' => "required|string|min:2|max:250|".$unique_reg_no,
            'color' => "required|string|min:2|max:250",
            'no_of_seats' => "required|integer|between:1,100",
            'type' => "required|string|min:2|max:250",
            'status' => 'required|in:ready,disposed_off,too_old,has_issues',
            'ownership' => 'required|in:company,hired',
            'cost_per_day' => ['required', 'numeric', 'min:0', 'max:999999999999999999999'],
            'code' => "required|alpha_dash|min:2|max:150|".$unique_code
        ]);
    }
}
