<?php 

namespace App\ClassTrait;

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
}

?>