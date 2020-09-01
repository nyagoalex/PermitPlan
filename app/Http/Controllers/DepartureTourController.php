<?php

namespace App\Http\Controllers;

use App\Http\Requests\DepartureTourRequest;
use App\Http\Resources\DepartureTourResource;
use App\Models\DepartureTour;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class DepartureTourController extends Controller
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
        $query  = DepartureTour::query();
        $query->when(request()->filled('active'), function ($query){
            $active = (request('active') === 'true') ? 1 : 0;
            return $query->whereActive($active);
        });
        $query->search(request('search'));
        $tours = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return DepartureTourResource::collection($tours);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartureTourRequest $request)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $data['user_id'] = Auth::id();
        $tour = DepartureTour::create($data);
        DB::commit();
        return new DepartureTourResource($tour);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // select a specific user of given id with the specified branch name and roles
        $tour = DepartureTour::findOrFail($id);
        return new DepartureTourResource($tour);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(DepartureTourRequest $request, $id)
    {
        DB::beginTransaction();
        $tour = DepartureTour::findOrFail($id);
        $data = $request->validated();
        $tour->update($data);
        DB::commit();
        return new DepartureTourResource($tour);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        $tour = DepartureTour::findOrFail($id);
        abort_unless($tour->deletable, Response::HTTP_BAD_REQUEST, 'Action Failed, Departure Tour Has Allocated Permits');
        $tour->delete();
        DB::commit();
        return new DepartureTourResource($tour);
    }

    public function deactivate(Request $request, $id)
    {
        #checks if user exists
        DB::beginTransaction();
        $tour = DepartureTour::findOrFail($id);

        // checks the current status of the user
        abort_unless($tour->active, Response::HTTP_BAD_REQUEST, 'tour already deactivated');

        #deactivation process
        $tour->active = false;
        $tour->save();
        DB::commit();
        return new DepartureTourResource($tour);
    }

    public function activate($id)
    {
        DB::beginTransaction();
        $tour = DepartureTour::findOrFail($id);
        // checks the current status of the user
        abort_if($tour->active, Response::HTTP_BAD_REQUEST, 'tour already active');
        #activation process
        $tour->active = true;
        $tour->save();
        DB::commit();
        return new DepartureTourResource($tour);
    }
}