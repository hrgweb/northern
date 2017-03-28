<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function show($custID)
    {
        $table = auth()->user()->identifyTableName(request('table'));
        $sales = $table.'.tblSales';
        $payment = $table.'.tblPmtMethod';

    	return DB::select(DB::raw("
			SELECT sales.SaleID, sales.ReceiptNo, CONVERT(DATE, sales.SaleDate) SaleDate, sales.TrayNo, staff.StaffName, sales.Subtotal, sales.Deposit, 
				payment.PmtMethod, sales.Balance
			FROM $sales AS sales
				JOIN dboOutletShared.tblStaffShared AS staff 
			ON staff.StaffID = sales.StaffID
				join $payment as payment
			ON payment.PmtMethodID = sales.PmtMethodID
			WHERE sales.CustID=?
		"), [$custID]);
    }

    public function transaction($receiptNo)
    {
        $table = auth()->user()->identifyTableName(request('table'));
        $salesTran = $table.'.tblSalesTran';

    	return DB::select(DB::raw("
    		SELECT Barcode, Description, Qty, Selling, TranTotal
    		FROM $salesTran 
    		WHERE ReceiptNo=?
		"), [$receiptNo]);
    }

    public function dispenseRight($saleID)
    {
        // $saleID = /*120205;*/ 194626;
        $table = auth()->user()->identifyTableName(request('table'));
        $dispense = $table.'.tblDispensing';
        $class = $table.'.tblClass';
        $st = $table.'.tblST';

        return DB::select(DB::raw("
            SELECT DispID, SPHRRX, CYLRRX, AXISRRX, SPHRLX, CYLRLX, AXISRLX, VA5, VA6,
                ADDRRX, ADDRLX, PDRRX, PDRLX, HTRRX, HTRLX, ClassName, CONVERT(DATE, OrderDate) OrderDate
            FROM $dispense AS dispense
                JOIN $class AS class
            ON class.ClassID = dispense.ClassID
                LEFT JOIN $st AS st
            ON st.STID = dispense.STID
            WHERE dispense.SaleID=?
        "), [$saleID]);
    }
}
