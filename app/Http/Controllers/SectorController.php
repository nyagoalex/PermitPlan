<?php

namespace App\Http\Controllers;

use App\Http\Resources\SectorResource;
use App\Models\Sector;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SectorController extends Controller
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
        $sector = Sector::orderBy($order_column, $sort)->paginate($per_page);
        
        return SectorResource::collection($sector);
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
        $sector = Sector::create($data);
        DB::commit();
        return new SectorResource($sector);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         // select a specific user of given id with the specified branch name and roles
         $sector = Sector::findOrFail($id);
         return new SectorResource($sector);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $sector = Sector::findOrFail($id);
        $data = $this->validateData();
        $sector->update($data);
        DB::commit();
        return new SectorResource($sector);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\models\Sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $sector = Sector::findOrFail($id);
        $sector->delete();
        DB::commit();
        return new SectorResource($sector);
    }

    private function validateData()
    {
        $request = Request();

        return $request->validate([
            'name' => "required|string|min:3|max:100",
            'national_park' => "required|string|min:3|max:200",
            'tracking_activity' => "required|string|min:3|max:250",
        ]);
    }
}
