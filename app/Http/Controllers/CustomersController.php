<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
	public function index()
	{
		// return auth()->user();

		return view('customers.index');
	}

	public function search()
	{
		return request()->all();
	}

	public function allCustomer($tblCustomer)
	{
		$table = '';

		switch ($tblCustomer) {
			case 'dboBPP.tblCustomer':
				$table = 'dboBPP';
				break;
			case 'dboBPE.tblCustomer':
				$table = 'dboBPE';
				break;
			case 'dboPA.tblCustomer':
				$table = 'dboPA';
				break;
		}

		// table to use to load customer data
		$table = $table . '.tblCustomer';

		// $records = DB::table($table)->get();					// orig
		$records =  DB::table($table)->limit(15)->get();		// tmp

		return ['records' => $records, 'table' => $table];
	}
}
