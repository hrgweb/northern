<?php

Route::get('/', function () {
    return view('welcome');
})->middleware('guest');

// SessionsController
Route::get('login', 'SessionsController@create');
Route::post('login', ['as' => 'login', 'uses' => 'SessionsController@store']);
Route::get('logout', 'SessionsController@destroy');
Route::get('/home', 'SessionsController@index')->name('home');

// CustomersController
Route::group(['prefix' => 'customers'], function() {
	Route::get('/', 'CustomersController@index'); 
	Route::get('/create', 'CustomersController@create'); 
	Route::post('/', 'CustomersController@store');
	Route::get('/allCustomer/{tblCustomer}', 'CustomersController@allCustomer'); 
	Route::get('/loadIc/{tblCustomer}', 'CustomersController@loadIc');
	Route::get('/loadEmails/{tblCustomer}', 'CustomersController@loadEmails'); 
});


// tmp
// Auth::routes();
// Route::get('/home', 'HomeController@index');
