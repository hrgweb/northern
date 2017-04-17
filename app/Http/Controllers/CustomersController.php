<?php

namespace App\Http\Controllers;

use App\BPECustomer;
use App\BPPCustomer;
use App\PACustomer;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CustomersController extends Controller
{
	private $column;
	private $table;
	private $query;
	private $filename;

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
			'ic' => 'required|alpha_num',
            'firstname' => 'required',
            'surname' => 'required',
			'postcode' => 'numeric|nullable',
			'email' => 'required|email',
			'homephone' => 'numeric|min:8|nullable',
			'handphone' => 'required|numeric|min:8'
		]);

		// check if validator fails then return errors
		if ($validator->fails()) {
			return response()->json(['isFail' => true, 'errors' => $validator->errors()]);
		}

        return request()->all();


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
        // $result = auth()->user()->postToTable($table, $data);

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
				SELECT TOP 10 [CustID]
				--SELECT [CustID]
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

	private function prepareToSearch()
	{
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
		    FROM $this->table
		  	WHERE " . $this->column . " LIKE '%" . $this->query . "%'"));
	}

	public function searchCustomer()
	{
		$this->column = request('column');
		$this->query = request('query');
		$this->table = request('table');

		// return 'column: '. $this->column . ', query: ' . $this->query . ', table: ' . $this->table;

		$results = '';

		// column to use in search
		switch(trim($this->column)) {
			case 'IC':
				$results = $this->prepareToSearch();
				break;
			case 'FirstName':
				$results = $this->prepareToSearch();
				break;
			case 'Surname':
				$results = $this->prepareToSearch();
				break;
			case 'HandPhone':
				$results = $this->prepareToSearch();
				break;
			case 'HomePhone':
				$results = $this->prepareToSearch();
				break;
			case 'Email':
				$results = $this->prepareToSearch();
				break;
		}

		return response()->json($results);
	}

	public function isIcExist($ic)
	{
		$table = request('table');

		return DB::table($table)->where('IC', $ic)->count();
	}

	public function signature()
	{
		return view('customers.signature');
	}

	protected function encodeImage($data_uri)
	{
		$encoded_image = explode(',', $data_uri)[1];

		return base64_decode($encoded_image);
	}

	protected function getFilepath($dir)
	{
		$this->filename = time().'.png';

		return public_path('img/'.$dir.'/'.$this->filename);
	}

	public function postSignature()
	{
		$data_uri = request('meta');

		// post signature
		file_put_contents($this->getFilepath('signatures'), $this->encodeImage($data_uri));

		return response()->json(['filename' => $this->filename]);
	}

	public function postAgreement()
	{
		$data_uri = request('file');
		$table = request('table');

		// post signature
		file_put_contents($this->getFilepath('page'), $this->encodeImage($data_uri));

		// post to database
		$table = auth()->user()->identifyTableName($table);
		$result = DB::table($table.'.tblWarrantyRegistration')->insert(request()->only(['ReceiptNo', 'Filename', 'Path']));

		return response()->json(['result' => $result]);
	}
}
