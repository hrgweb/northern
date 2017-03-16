<?php

namespace App\Http\Controllers;

use App\BPECustomer;
use App\BPPCustomer;
use App\PACustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		// return auth()->user();

		return view('customers.index');
	}

	public function create()
	{
		return view('customers.create');
	}

	public function store()
	{
		$table = trim(request('table'));
		// $validate = "unique:{$table},Email";

		$validator = Validator::make(request()->all(), [
			'id' => 'numeric|max:2147483647',
			'ic' => 'string|nullable',
			'postcode' => 'numeric|nullable',
			'email' => 'email|nullable',
			'homephone' => 'min:8|numeric|nullable',
			'handphone' => 'min:8|numeric|nullable',
		]);

		// check if validator fails
		if ($validator->fails()) {
            return ['isFail' => true, 'errors' => $validator->errors()];
        }

        // post new customer
        $data = [
        	'Block' => request('block'),
        	'Building' => request('building'),
        	'Country' => request('country'),
        	'DOB' => request('dob'), // . ' 00:00:00',
        	'Email' => request('email'),
        	'FirstName' => request('firstname'),
        	'Gender' => (strtolower(request('gender')) == 'female') ? 'F' : 'M',
        	'HandPhone' => request('handphone'),
        	'HomePhone' => request('homephone'),
        	'IC' => request('ic'),
        	'CustID' => request('id'),
        	'Occupation' => request('occupation'),
        	'Postcode' => request('postcode'),
        	'Remark' => request('remarks'),
        	'Salutation' => request('salutation'),
        	'Street' => request('street'),
        	'Surname' => request('surname'),
        	'Unit' => request('unit_no'),
        	'System' => false
        ];

        $result = [];

        switch (trim($table)) {
			case 'dboBPP.tblCustomer':
				$result = BPPCustomer::insert($data);
				break;
			case 'dboBPE.tblCustomer':
				$result = BPECustomer::insert($data);
				break;
			case 'dboPA.tblCustomer':
				$result = PACustomer::insert($data);
				break;
		}

        return ['isFail' => false, 'records' => $result];
	}

	public function search()
	{
		return request()->all();
	}

	public function allCustomer($tblCustomer)
	{
		$table = '';

		switch (trim($tblCustomer)) {
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

	public function loadIc($table)
	{
		return DB::table($table)
			->select('IC')
			->distinct()
			->limit(3) // to be remove. just tmp
			// ->orderBy('CustID', 'desc') // to be remove. just tmp
			->get();
	}

	public function loadEmails($table)
	{
		return DB::table($table)
			->select('Email')
			->distinct()
			->limit(3) // tmp
			// ->orderBy('Email', 'asc')
			->orderBy('Email', 'desc')
			->get();
	}
}
