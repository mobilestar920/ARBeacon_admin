<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('manage_beacon');
    } else {
        return view('login');
    }
});

Route::namespace('Auth')->group(function () {
    Route::get('/login','LoginController@show_login_form')->name('login');
    Route::post('/login','LoginController@process_login')->name('login_post');
    Route::get('/register','LoginController@show_signup_form')->name('go_register');
    Route::post('/register','LoginController@process_signup')->name('register');
    Route::get('/logout','LoginController@logout')->name('logout');
});

Route::prefix('beacon')->group(function () {
    Route::get('/','ManageBeaconController@index')->name('manage_beacon');
    Route::get('/characters/{uuid}','ManageBeaconController@getCharacters')->name('beacon_characters');
    Route::post('/add','ManageBeaconController@addBeacon')->name('add_beacon');
    Route::post('/edit','ManageBeaconController@editBeacon')->name('edit_beacon');
    Route::post('/delete/{beacon_id}','ManageBeaconController@editBeacon')->name('delete_beacon');
    Route::post('/add/character','ManageBeaconController@addCharacterToBeacon')->name('register_character');
});

Route::prefix('character')->group(function () {
    Route::get('/','ManageCharacterController@index')->name('manage_character');
    Route::post('/add','ManageCharacterController@createCharacter')->name('add_character');
    Route::post('/edit','ManageCharacterController@editCharacter')->name('edit_character');
    Route::post('/delete/{beacon_id}','ManageCharacterController@deleteCharacter')->name('delete_character');
});