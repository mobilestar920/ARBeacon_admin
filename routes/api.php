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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/beacon/register', 'Api\ApiLocationController@registerBeacon');
Route::post('v1/beacon/check', 'Api\ApiLocationController@checkBeacon');
Route::get('v1/beacons', 'Api\ApiLocationController@getBeaconList');
Route::get('v1/beacons/{uuid}', 'Api\ApiLocationController@getBeaconData');
Route::get('v1/beacons/{uuid}/character', 'Api\ApiLocationController@getCharacterData');