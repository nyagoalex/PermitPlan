<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('register', 'Tenant\RegisterTenantController')->name('register.tenant');

Route::get('/nnn', function () {  
    $r = ['domain' => 'name'];
    return response()->json([ 'data' => $r ]);
});
