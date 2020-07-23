<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermitTypeResource;
use App\Models\PermitType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermitTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type = PermitType::all();
        return PermitTypeResource::collection($type->keyBy('name'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PermitType  $permitType
     * @return \Illuminate\Http\Response
     */
    public function show($name)
    {
         // select a specific user of given id with the specified branch name and roles
         $type = PermitType::whereName($name)->firstOrFail();
         return new PermitTypeResource($type);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PermitType  $permitType
     * @return \Illuminate\Http\Response
     */
    public function update($name)
    {
        DB::beginTransaction();
        $type = PermitType::whereName($name)->firstOrFail();
        $data = $this->validateData();
        $type->update($data);
        DB::commit();
        return new PermitTypeResource($type);
    }


    private function validateData()
    {
        $request = Request();

        return $request->validate([
            'east_african_cost' => "required|numeric|gte:0|lte:999999.99",
            'foreign_resident_cost' => "required|numeric|gte:0|lte:999999.99",
            'non_resident_cost' => "required|numeric|gte:0|lte:999999.99",
            'ugandan_cost' => "required|numeric|gte:0|lte:999999.99",
        ]);
    }
}
