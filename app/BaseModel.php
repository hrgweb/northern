<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
	protected $guarded = [];
	protected $dates = ['DOB'];
	public $timestamps = false;

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s.u';
    }

    public function fromDateTime($value)
    {
        return substr(parent::fromDateTime($value), 0, -3);
    }
}

?>