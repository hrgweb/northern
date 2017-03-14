<?php

Route::get('/', function () {
    return view('welcome');
});

// SessionsController
Route::get('login', 'SessionsController@create');
Route::post('login', ['as' => 'login', 'uses' => 'SessionsController@store']);
Route::get('logout', 'SessionsController@destroy');
Route::get('/home', 'SessionsController@index')->name('home');

// CustomersController
Route::group(['prefix' => 'customers'], function() {
	Route::get('/', 'CustomersController@index'); 
	Route::get('/allCustomer/{tblCustomer}', 'CustomersController@allCustomer'); 
});


// tmp
// Auth::routes();
// Route::get('/home', 'HomeController@index');
