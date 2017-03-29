<?php

// tmp
Route::get('query', function() {
	$saleID = 194626;
	// $saleID = 120204;
    // $table = auth()->user()->identifyTableName(request('table'));
    $table = 'dboBPP';
    $dispense = $table.'.tblDispensing';
    $class = $table.'.tblClass';
    $st = $table.'.tblST';

    return DB::select(DB::raw("
        SELECT DispID, SPHRRX, CYLRRX, AXISRRX, SPHRLX, CYLRLX, AXISRLX, VA5, VA6,
            ADDRRX, ADDRLX, PDRRX, PDRLX, HTRRX, HTRLX, ClassName, CONVERT(DATE, OrderDate) OrderDate
        FROM $dispense AS dispense
            LEFT JOIN $class AS class
        ON class.ClassID = dispense.ClassID
            LEFT JOIN $st AS st
        ON st.STID = dispense.STID
        WHERE dispense.SaleID=?
    "), [$saleID]);
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
	Route::get('/allCustomer/{tblCustomer}', 'CustomersController@allCustomer'); 
	Route::get('/loadIc/{tblCustomer}', 'CustomersController@loadIc');
	Route::get('/loadEmails/{tblCustomer}', 'CustomersController@loadEmails'); 
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
