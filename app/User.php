<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['ID'];
    protected $hidden = ['password', 'remember_token'];
    protected $table = 'dboOutletShared.tblOnlineAppAccessList';
    protected $primaryKey = 'ID';
}
