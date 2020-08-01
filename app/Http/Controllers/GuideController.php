<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuideResource;
use App\Models\Guide;
use App\Rules\PhoneValidator;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuideController extends Controller
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
        $order_column = $this->getOrderColumn("experience_since");
        
        $query = Guide::query();
        $query->when(request()->filled('status'), function ($query){
            return $query->whereStatus(request('status'));
        });
        $query->when(request()->filled('contract_basis'), function ($query){
            return $query->whereContractBasis(request('contract_basis'));
        });
        $guide = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        
        return GuideResource::collection($guide);
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
        $data['code'] = "GD".sprintf('%04d', Guide::count() + 1);
        $guide = Guide::create($data);
        DB::commit();
        return new GuideResource($guide);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $guide = Guide::findOrFail($id);
        return new GuideResource($guide);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $guide = Guide::findOrFail($id);
        $data = $this->validateData();
        $guide->update($data);
        DB::commit();
        return new GuideResource($guide);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Guide  $guide
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $guide = Guide::findOrFail($id);
        $guide->delete();
        DB::commit();
        return new GuideResource($guide);
    }

    private function validateData()
    {
        $request = Request();
        $today = today()->format('Y-m-d');
        return $request->validate([
            'first_name' => "required|string|min:3|max:250",
            'last_name' => "required|string|min:3|max:250",
            'dob' => "required|date_format:Y-m-d|before:experience_since",
            'experience_since' => "required|date_format:Y-m-d|before_or_equal:$today",
            'email' => "nullable|email:filter",
            "phone" => ['required', new PhoneValidator],
            'contract_basis' => 'required|in:full_time,freelancer',
            'status' => 'required|in:working,terminated,probation',
            'cost_per_day' => ['required', 'numeric', 'min:0', 'max:999999999999999999999'],
            'parks_experience' => ['nullable', 'array'],
            'vehicle_types_experience' => ['nullable', 'array']
        ]);
    }
}
