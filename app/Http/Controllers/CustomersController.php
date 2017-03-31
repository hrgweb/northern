<?php

namespace App\Http\Controllers;

use App\BPECustomer;
use App\BPPCustomer;
use App\Http\Requests\CustomerRequest;
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

		$validator = Validator::make(request()->all(), [
			'id' => 'numeric|max:2147483647',
			'ic' => 'string|nullable',
			'postcode' => 'numeric|nullable',
			'email' => 'email|nullable',
			'homephone' => 'min:8|numeric|nullable',
			'handphone' => 'min:8|numeric|nullable',
		]);

		// check if validator fails then return errors
		if ($validator->fails()) return response()->json(['isFail' => true, 'errors' => $validator->errors()]);

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

        return response()->json(['isFail' => false, 'records' => $result]);
	}

	public function update($customer)
	{
		$table = request('table');

		$validator = Validator::make(request()->all(), [
            'IC' => 'string|nullable',
            'Postcode' => 'numeric|nullable',
            'Email' => 'email|nullable',
            'HomePhone' => 'min:8|numeric|nullable',
            'HandPhone' => 'min:8|numeric|nullable',
        ]);

        // check if validator fails then return errors
        if ($validator->fails()) return response()->json(['isFail' => true, 'errors' => $validator->errors()]);

        // remove the key from collection/object
        $data = collect(request()->all())->except(['table']);

        // convert object into associative array
        $data = json_decode(json_encode($data), true);

        $result = [];

        switch ($table) {
            case 'dboBPP.tblCustomer':
            	$result = BPPCustomer::findOrFail($customer)->update($data);
                break;
            case 'dboBPE.tblCustomer':
            	$result = BPECustomer::findOrFail($customer)->update($data);
                break;
            case 'dboPA.tblCustomer':
            	$result = PACustomer::findOrFail($customer)->update($data);
                break;
        }

        // return ['isFail' => false, 'records' => $data, 'result' => $result];
        return response()->json(['isFail' => false, 'records' => $data]);
	}

	public function search()
	{
		return request()->all();
	}

	public function allCustomer($tblCustomer)
	{
		$table = auth()->user()->identifyTableName($tblCustomer);
		$table = $table . '.tblCustomer';

		// orig
		$records = DB::select(DB::raw("
				SELECT [CustID]
				-- SELECT TOP 10 [CustID]
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
					, CONVERT(DATE, [DOB]) DOB
					,[Gender]
					,[Occupation]
					,[HomePhone]
					,[HandPhone]
					,[Email]
					,[Remark]
					,[SYSTEM]
				FROM $table
				--WHERE CustID=3938
				--WHERE DOB IS NOT NULL
			"));

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

	public function getLastId()
	{
		$table = request('table');

		return DB::table($table)->max('CustID');
	}
}
