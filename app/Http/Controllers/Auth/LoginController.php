<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

        $user = auth()->user();
		$user['access_token'] = $user->createToken('authToken')->accessToken;

        return response()->json(['data' => $user], 200);
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

    //  /**
    //  * details api
    //  *
    //  * @return mixed
    //  */
    // public function profile()
    // {
    //     $user = Auth::user();
    //     $user = User::FindOrFail($user->id);
    //     return new LoginedInUserResource($user);
    // }
}
