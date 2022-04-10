<?php

Route::group(['module' => 'contact', 'namespace' => 'Gamota\Contacts\Http\Controllers\Admin', 'middleware' => ['web'], 'prefix' => 'admin/contact'], function () {
    Route::get('/', 'ContactController@index')->name('admin.contact.index')->middleware('can:admin.contacts.index');
    Route::get('{contact}/detail', 'ContactController@detail')->name('admin.contact.detail')->middleware('can:admin.contacts.index');
    
    
    
   

});