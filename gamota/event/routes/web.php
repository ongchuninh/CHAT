<?php

/* BEGIN OF FRONTEND =================================================================================== */
Route::group(['module' => 'event', 'namespace' => 'Gamota\Event\Http\Controllers\Frontend'], function () {
    Route::get('trian_vip', 'MembershipController@index')->name('frontend.membership.index');
});

/* BEGIN OF MEMBERSHIP =================================================================================== */
Route::group(['module' => 'event', 'namespace' => 'Gamota\Event\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/event/membership'], function () {
	/* ADMIN ==========================*/
	Route::get('/', 'MembershipController@index')->name('admin.event.membership.index')->middleware('can:admin.event.membership.index');
	Route::get('/list_role', 'MembershipController@list_role')->name('admin.event.membership.list_role')->middleware('can:admin.event.membership.list_role');
	Route::post('/export', 'MembershipController@export')->name('admin.event.membership.export')->middleware('can:admin.event.membership.export');

});
Route::group(['module' => 'event', 'namespace' => 'Gamota\Event\Http\Controllers\Frontend', 'middleware' => ['web'], 'prefix' => 'membership'], function () {
	/* FRONTEND ==========================*/
	Route::get('ajax_getLevelVip', 'MembershipController@ajax_getLevelVip')->name('frontend.membership.ajax_getLevelVip');
	Route::get('ajax_updateUserInfo', 'MembershipController@ajax_updateUserInfo')->name('frontend.membership.ajax_updateUserInfo');
});

/* BEGIN OF ACC =================================================================================== */
Route::group(['module' => 'event', 'namespace' => 'Gamota\Event\Http\Controllers\Frontend', 'middleware' => ['web'], 'prefix' => 'acc'], function () {
	Route::get('login', 'AccController@login')->name('frontend.acc.login');
	Route::get('logout', 'AccController@logout')->name('frontend.acc.logout');
	Route::get('test', 'AccController@test')->name('frontend.acc.test');
	Route::get('get_ses', 'AccController@get_ses')->name('frontend.acc.get_ses');
	Route::get('save_ses', 'AccController@save_ses')->name('frontend.acc.save_ses');

	Route::get('getRoleInfo', 'AccController@getRoleInfo')->name('frontend.acc.getRoleInfo');
	Route::get('getListServer', 'AccController@getListServer')->name('frontend.acc.getListServer');
});