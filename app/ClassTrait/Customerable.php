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

    public static function insert(array $data)
    {
        return static::create($data);
    }
}

?>