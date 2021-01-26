<?php

namespace App\Http\Controllers;

use App\Http\Resources\LodgeResource;
use App\Http\Resources\lodgeSeasonalPricesResource;
use App\Http\Resources\SingleLodgeResource;
use App\Models\Lodge;
use App\Models\Season;
use App\Rules\PhoneValidator;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LodgeController extends Controller
{
    use HelperTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function lodgeSeasonalPrices()
    {
        $sort = $this->getSort();
        $per_page = $this->getPerPage();
        $order_column = $this->getOrderColumn("name");
        $query = Lodge::query();
        $query->search(request('search'));
        $lodges = $query->orderBy($order_column, $sort)->paginate($per_page);
        return lodgeSeasonalPricesResource::collection($lodges);
    }

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
        $query = Lodge::query();
        $query->search(request('search'));
        $lodges = $query->orderBy($order_column, $sort)->paginate($per_page);
        return LodgeResource::collection($lodges);
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
        $data['code'] =$this->nextNumber(Lodge::query(), 'code', 'L');
        $lodge = Lodge::create($data);
        DB::commit();
        return new LodgeResource($lodge);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lodge  $lodge
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lodge = Lodge::with('rooms', 'activities', 'facilities', 'seasons', 'rooms.costs')->findOrFail($id);
        return new SingleLodgeResource($lodge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lodge  $lodge
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        DB::beginTransaction();
        $lodge = Lodge::findOrFail($id);
        $data = $this->validateUpdateData();
        $lodge->update($data);
        DB::commit();
        return new LodgeResource($lodge);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lodge  $lodge
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $lodge = Lodge::findOrFail($id);
        $lodge->delete();
        DB::commit();
        return new LodgeResource($lodge);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lodge  $lodge
     * @return \Illuminate\Http\Response
     */
    public function updateStarRating($id)
    {
        DB::beginTransaction();
        $lodge = Lodge::findOrFail($id);
        $data = request()->validate([
            'star_rating' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);
        $lodge->update(collect($data)->only(['star_rating'])->toArray());
        DB::commit();
        return new LodgeResource($lodge);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lodge  $lodge
     * @return \Illuminate\Http\Response
     */
    public function updateContractedRating($id)
    {
        DB::beginTransaction();
        $lodge = Lodge::findOrFail($id);
        $data = request()->validate([
            'contracted_rating' => ['required', 'numeric', 'min:0', 'max:99.99'],
        ]);
        $lodge->update(collect($data)->only(['contracted_rating'])->toArray());
        DB::commit();
        return new LodgeResource($lodge);
    }
    private function validateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:3|max:250",
            'star_rating' => ['required', 'numeric', 'min:0', 'max:5'],
            'contracted_rating' => ['required', 'numeric', 'min:0', 'max:99.99'],
            'email' => "nullable|email:filter",
            "phone" => ['nullable', new PhoneValidator],
            'address' => "nullable|string|min:2|max:250",
            'country' => "required|string|min:2|max:250",
            'location' => "required|string|min:2|max:250",
        ]);
    }
    private function validateUpdateData()
    {
        $request = Request();
        return $request->validate([
            'name' => "required|string|min:3|max:250",
            'contracted_rating' => ['required', 'numeric', 'min:0', 'max:99.99'],
            'email' => "nullable|email:filter",
            "phone" => ['nullable', new PhoneValidator],
            'address' => "nullable|string|min:2|max:250",
            'country' => "required|string|min:2|max:250",
            'location' => "required|string|min:2|max:250",
        ]);
    }
    private function validateStarRating()
    {
        $request = Request();
        return $request->validate([
            'star_rating' => ['required', 'numeric', 'min:0', 'max:5'],
        ]);
    }
}
