<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PACustomer extends Model
{
    protected $guarded = ['CustID'];
    protected $table = 'dboPA.tblCustomer';
    protected $primaryKey = 'CustID';
}
