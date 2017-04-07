<?php 

namespace App\ClassTrait;

use App\BPECustomer;
use App\BPPCustomer;
use App\PACustomer;

trait DataTable
{
	public function identifyTableName($tableName)
	{
		$table = '';

		switch (trim($tableName)) {
			case 'dboBPP.tblCustomer':
				$table = 'dboBPP';
				break;
			case 'dboBPE.tblCustomer':
				$table = 'dboBPE';
				break;
			case 'dboPA.tblCustomer':
				$table = 'dboPA';
				break;
		}

		return $table;
	}

	public function postToTable($table, array $data)
    {
        $result = [];

        switch (trim($table)) {
            case 'dboBPP.tblCustomer':
                $result = BPPCustomer::create($data);
                break;
            case 'dboBPE.tblCustomer':
                $result = BPECustomer::create($data);
                break;
            case 'dboPA.tblCustomer':
                $result = PACustomer::create($data);
                break;
        }

        return $result;
    }
}

?>