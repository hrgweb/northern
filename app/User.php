<?php

namespace App;

use App\ClassTrait\Customerable;
use App\ClassTrait\DataTable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, DataTable, Customerable;

    protected $guarded = ['ID'];
    protected $hidden = ['password', 'remember_token'];
    protected $table = 'dboOutletShared.tblOnlineAppAccessList';
    protected $primaryKey = 'ID';
}
