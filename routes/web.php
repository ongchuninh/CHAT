<?php

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

// Route::get('/', 'HomeController@landing')->name('/');
// Route::get('/hero', 'HomeController@hero')->name('hero');
// Route::get('/trang-chu', 'HomeController@index')->name('home');
// Route::get('/{any}-{id}.html','HomeController@detail')->where('id', '[0-9]+');
// Route::get('{any}.html','HomeController@listdetail');

// //dowload qr
// Route::get('/download_qr', 'HomeController@download')->name('download');




Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::get('/','HomeController@index')->name('client.home');
Route::get('/service','HomeController@Service')->name('client.service');
Route::get('/gamota','HomeController@Gamota')->name('client.gamota');
Route::get('/games','HomeController@Games')->name('client.games');
Route::get('/contact','HomeController@Contact')->name('client.contact');

Route::get('/tin-tuc','HomeController@listNews')->name('client.listNews');

Route::get('/tin-tuc/{cate?}/{slug?}','HomeController@newDetail')->name('client.newDetail');

// Route::get('artisan',function(){
//     Artisan::call('migrate', ["--force"=> true ]);
//     echo "tc";
// });

Auth::routes();