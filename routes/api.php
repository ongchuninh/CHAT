<?php

use Illuminate\Http\Request;

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
Route::group(['namespace' => 'Api','middleware' => ['web']], function () {
    Route::get('get_list_game','APIController@getListgame')->name('api.game.get_list_game');
    Route::get('get_language','APIController@getListLanguage')->name('api.language.get_language');

    Route::post('contact','APIController@contact')->name('api.contact');

    Route::get('change_languege','APIController@changeLanguege')->name('api.changeLanguage');


    Route::get('get_game','APIController@getGame')->name('api.getGame');

   

    

});