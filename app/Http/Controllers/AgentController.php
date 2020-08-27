<?php

namespace App\Http\Controllers;

use App\Http\Requests\AgentRequest;
use App\Http\Resources\AgentResource;
use App\Models\Agent;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AgentController extends Controller
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
        $query  = Agent::query();
        $query->when(request()->filled('active'), function ($query){
            $active = (request('active') === 'true') ? 1 : 0;
            return $query->whereActive($active);
        });
        $query->search(request('search'));
        $agents = $query->orderBy($order_column, $sort)->paginate($per_page);
        
        return AgentResource::collection($agents);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgentRequest $request)
    {
        #insert new user
        DB::beginTransaction();
        $data = $request->validated();
        $agent = Agent::create($data);
        DB::commit();
        return new AgentResource($agent);
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
        $agent = Agent::findOrFail($id);
        return new AgentResource($agent);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Agent  $agent
     * @return \Illuminate\Http\Response
     */
    public function update(AgentRequest $request, $id)
    {
        DB::beginTransaction();
        $agent = Agent::findOrFail($id);
        $data = $request->validated();
        $agent->update($data);
        DB::commit();
        return new AgentResource($agent);
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
        $agent = Agent::findOrFail($id);
        $agent->delete();
        DB::commit();
        return new AgentResource($agent);
    }

    public function deactivate(Request $request, $id)
    {
        #checks if user exists
        DB::beginTransaction();
        $agent = Agent::findOrFail($id);

        // checks the current status of the user
        abort_unless($agent->active, Response::HTTP_BAD_REQUEST, 'agent already deactivated');
        #user can't deactivate him/herself
        abort_if($id == Auth()->user()->id, Response::HTTP_UNPROCESSABLE_ENTITY, "Request failed agent can't deactivate self");

        #deactivation process
        $agent->active = false;
        $agent->save();
        DB::commit();
        return new AgentResource($agent);
    }

    public function activate($id)
    {
        DB::beginTransaction();
        $agent = Agent::findOrFail($id);
        // checks the current status of the user
        abort_if($agent->active, Response::HTTP_BAD_REQUEST, 'agent already active');
        #activation process
        $agent->active = true;
        $agent->save();
        DB::commit();
        return new AgentResource($agent);
    }
}
