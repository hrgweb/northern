<?php 

namespace App\ClassTrait;

use Carbon\Carbon;

trait Customerable
{
    public function setIcAttribute($ic)
    {
        $this->attributes['IC'] = strtoupper($ic);
    }

	public function setCountryAttribute($country)
    {
    	$this->attributes['Country'] = strtoupper($country);
    }

    public function setFirstnameAttribute($firstname)
    {
    	$this->attributes['FirstName'] = strtoupper($firstname);
    }

    public function setSurnameAttribute($surname)
    {
    	$this->attributes['Surname'] = strtoupper($surname);
    }

    public function setOccupationAttribute($occupation)
    {
    	$this->attributes['Occupation'] = strtoupper($occupation);
    }

    public function setSalutationAttribute($salutation)
    {
    	$this->attributes['Salutation'] = strtoupper($salutation);
    }

    public function setBuildingAttribute($building)
    {
    	$this->attributes['Building'] = strtoupper($building);
    }

    public function setDOBAttribute($dob)
    {
    	$this->attributes['DOB'] = Carbon::parse($dob);
    }

    public function setStreetAttribute($street)
    {
        $this->attributes['Street'] = strtoupper($street);
    }

    public function setRemarkAttribute($remark)
    {
        $this->attributes['Remark'] = strtoupper($remark);
    }

    public function setEmailAttribute($email)
    {
        $this->attributes['Email'] = strtoupper($email);
    }

    public function prepare($table, $request)
    {
        dd($request);

        $validator = Validator::make(request()->all(), [
            'id' => 'numeric|max:2147483647',
            'ic' => 'string|nullable',
            'postcode' => 'numeric|nullable',
            'email' => 'email|nullable',
            'homephone' => 'min:8|numeric|nullable',
            'handphone' => 'min:8|numeric|nullable',
        ]);

        // check if validator fails then return errors
        if ($validator->fails()) return ['isFail' => true, 'errors' => $validator->errors()];

        // prepare data for posting
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

        // return $this->tableToInsert($table, );

    }

    public static function insert(array $data)
    {
        return static::create($data);
    }

    private function tableToInsert($table, array $data)
    {
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

        return $result;
    }
}

?>