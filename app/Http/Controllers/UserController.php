<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
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
        $order_column = $this->getOrderColumn("first_name");
        $users = User::orderBy($order_column, $sort)->paginate($per_page);
        
        return UserResource::collection($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
         #insert new user
         DB::beginTransaction();
         $data = $request->validated();
         $data['password'] = Hash::make($data['password']);
         $user = User::create($data);
         DB::commit();
         return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // select a specific user of given id with the specified branch name and roles
        $user = User::findOrFail($id);
        return new UserResource($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        DB::beginTransaction();
        $user = User::findOrFail($id);
        $data = $request->validated();
        $user->update(collect($data)->except(['password', 'failed_login_count', 'username'])->toArray());
        DB::commit();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        #checks if user exists
        DB::beginTransaction();
        $user = User::findOrFail($id);
        #user can't delete him/herself
        abort_if($id == Auth()->user()->id, Response::HTTP_UNPROCESSABLE_ENTITY, "Request failed user can't delete self");
        #delete process
        $user->delete();
        DB::commit();
        return new UserResource($user);
    }

    public function deactivateUser(Request $request, $id)
    {
        #checks if user exists
        DB::beginTransaction();
        $user = User::findOrFail($id);

        // checks the current status of the user
        abort_unless($user->active, Response::HTTP_BAD_REQUEST, 'user already deactivated');
        #user can't deactivate him/herself
        abort_if($id == Auth()->user()->id, Response::HTTP_UNPROCESSABLE_ENTITY, "Request failed user can't deactivate self");

        #deactivation process
        $user->status = 'inactive';
        $user->save();
        DB::commit();
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Illuminate\Http\Request $request request object
     * @param int                      $id      resource id
     *                                          Illuminate\Http\JsonResponse
     *                                          json
     *                                          response
     *                                          object
     */

    public function activateUser(Request $request, $id)
    {
        unset($request);
        DB::beginTransaction();
        #checks if user exists
        $user = User::findOrFail($id);

        // checks the current status of the user
        abort_if($user->active, Response::HTTP_BAD_REQUEST, 'user_already_activated');

        #activation process
        $user->status = 'active';
        $user->save();
        DB::commit();
        return new UserResource($user);
    }
}
