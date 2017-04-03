<?php

// tmp
Route::get('query', function() {
	return DB::select(DB::raw("
        SELECT [CustID]
          ,[IC]
          ,[Salutation]
          ,[Surname]
          ,[FirstName]
          ,[Block]
          ,[Unit]
          ,[Building]
          ,[Street]
          ,[Country]
          ,[Postcode]
          ,CONVERT(DATE, [DOB]) AS DOB
          ,[Gender]
          ,[Occupation]
          ,[HomePhone]
          ,[HandPhone]
          ,[Email]
          ,[Remark]
          ,[System]
      FROM [dboBPP].[tblCustomer]
    "));
});

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
    Route::put('/{customer}', 'CustomersController@update');
    Route::get('/customerID', 'CustomersController@getLastId');
    Route::get('/search', 'CustomersController@searchCustomer'); 
    Route::get('/allCustomer/{tblCustomer}', 'CustomersController@allCustomer'); 
    Route::get('/loadIc/{tblCustomer}', 'CustomersController@loadIc');
    Route::get('/loadEmails/{tblCustomer}', 'CustomersController@loadEmails'); 
    Route::get('/checkIc/{email}', 'CustomersController@isIcExist'); 
});

// PurchaseController
Route::group(['prefix' => 'purchases'], function() {
	Route::get('/{id}', 'PurchaseController@show');
	Route::get('/transactions/{id}', 'PurchaseController@transaction');
	Route::get('/dispenseRight/{id}', 'PurchaseController@dispenseRight');
    Route::get('/dispenseLeft/{id}', 'PurchaseController@dispenseLeft');
	Route::get('/stLeft/{id}', 'PurchaseController@stLeft');
});


// tmp
// Auth::routes();
// Route::get('/home', 'HomeController@index');
