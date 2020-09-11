<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\SettingResource;
use App\Http\Resources\UserResource;
use App\Models\Setting;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends  AccessTokenController
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function login(Request $request)
    {
        $loginData = $request->validate([
            'username' => 'string|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($loginData)) {
            abort(Response::HTTP_UNAUTHORIZED, "Login Failed! Invalid Username Or Password");
        }

        $auth = auth()->user();
        $user = [
            'id' => $auth->id,
            'full_name' => $auth->full_name,
            'access_token' => $auth->createToken('authToken')->accessToken, 
        ];
        $data['user'] =  $user;
        $data['settings'] =  new SettingResource(Setting::first());
        return response()->json(['data' => $data], 200);
    }

        /**
     * Logout user (Revoke the token)
     *
     * @param \Illuminate\Http\Request $request request object
     *
     * @return mixed
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return response(['message' => 'Successfully logged out'], Response::HTTP_OK);
    }

     /**
     * details api
     *
     * @return mixed
     */
    public function profile()
    {
        $user_id = Auth::id();
        $user = User::FindOrFail($user_id);
        return new UserResource($user);
    }
}
