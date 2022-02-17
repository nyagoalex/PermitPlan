<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterTenantRequest;
use App\Models\User;
use App\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterTenantController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(RegisterTenantRequest $request)
    {
        DB::beginTransaction();
        $data = $request->validated();

        $tenant = Tenant::create([
            'id' => $data['company_name'],
        ]);
        $tenant->domains()->create(['domain' => $data['company_name']]);

        $user = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'username' => $data['username'],
            'phone' => '256700000000',
            'password' => Hash::make($data['password']),
            'last_pass_reset_date' => today(),
            'active' => true,
            'email' => $data['email']
        ];

        $tenant->run(function () use ($user){
            User::create($user);
        });
//        Artisan::call("tenants:seed --tenants=".$data['company_name']);
        DB::commit();

        return response()->json([ 'data' => $tenant->domains()->first('domain')]);
    }
}
