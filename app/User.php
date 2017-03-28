<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\ClassTrait\DataTable;

class User extends Authenticatable
{
    use Notifiable, DataTable;

    protected $guarded = ['ID'];
    protected $hidden = ['password', 'remember_token'];
    protected $table = 'dboOutletShared.tblOnlineAppAccessList';
    protected $primaryKey = 'ID';
}
