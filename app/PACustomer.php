<?php

namespace App;

use App\BaseModel;
use App\ClassTrait\Customerable;

class PACustomer extends BaseModel
{
	use Customerable;

    protected $table = 'dboPA.tblCustomer';
}
