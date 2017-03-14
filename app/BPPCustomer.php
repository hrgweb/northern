<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BPPCustomer extends Model
{
    protected $guarded = ['CustID'];
    protected $table = 'dboBPP.tblCustomer';
    protected $primaryKey = 'CustID';
}
