<?php

namespace App;

use App\BaseModel;
use App\ClassTrait\Customerable;

class BPPCustomer extends BaseModel
{
	use Customerable;

    protected $table = 'dboBPP.tblCustomer';
}
