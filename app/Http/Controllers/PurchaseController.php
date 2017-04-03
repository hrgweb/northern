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
            ORDER BY sales.ReceiptNo DESC
		"), [$custID]);
    }

    public function transaction($receiptNo)
    {
        $table = auth()->user()->identifyTableName(request('table'));
        $salesTran = $table.'.tblSalesTran';

        return DB::table($salesTran)
            ->selectRaw('Barcode, Description, Qty, ROUND(Selling, 2) AS Selling, ROUND(TranTotal, 2) AS TranTotal')
            ->where('ReceiptNo', $receiptNo)
            ->get();
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

    public function dispenseLeft($custID)
    {
        $table = auth()->user()->identifyTableName(request('table'));
        $dispense = $table.'.tblDispensing';
        $class = $table.'.tblClass';

        return DB::select(DB::raw("
            SELECT class.ClassName, dispense.DispID, dispense.STID, CONVERT(DATE, dispense.OrderDate) OrderDate
            FROM $dispense as dispense
                JOIN $class as class
            ON class.ClassID = dispense.ClassID
            WHERE CustID=?
            ORDER BY dispense.DispID DESC
        "), [$custID]);
    }

    public function stLeft($custID)
    {
        $table = auth()->user()->identifyTableName(request('table'));
        $st = $table.'.tblST';

        return DB::select(DB::raw("
            SELECT STID, CONVERT(DATE, STDate) STDate, StaffName
            FROM $st AS st
                JOIN dboOutletShared.tblStaffShared AS staff
            ON staff.StaffID = st.staffID
            WHERE CustID=?
            ORDER BY STID DESC
        "), [$custID]);
    }
}
