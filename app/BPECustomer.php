<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BPECustomer extends Model
{
    protected $guarded = ['CustID'];
    protected $table = 'dboBPE.tblCustomer';
    protected $primaryKey = 'CustID';
}
