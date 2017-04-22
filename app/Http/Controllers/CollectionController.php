<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('collections.index');
    }

    public function store(Request $request)
    {
    	$table = $this->storePrefix('tblCollection');

    	$request['CollectID'] = $this->collectionLastID();
        $request['CollectDate'] = date('Y-m-d');
        $request['CollectTime'] = date('Y-m-d H:i:s');
        $data = request()->except('table');

        // post to db
        $result = DB::table($table)->insert($data);

        return response()->json([
    		'result' => [request()->only(['SaleID', 'ReceiptNo', 'PmtAmount'])], 
    		'isSuccess' => $result
        ]);
    }

    public function receiptList()
    {
    	$table = $this->storePrefix('tblSales');

        return DB::select(DB::raw("
            SELECT SaleID, ReceiptNo AS Receipt, SaleDate AS [Date], /*Format(Nz([Balance])-Nz([collectedamt],0),'Standard') AS Bal,*/ Collected
            FROM $table
            WHERE Collected=0 AND Balance Is Not Null
            ORDER BY SaleDate, ReceiptNo
        "));
    }

    public function staffList()
    {
    	return DB::select(DB::raw("
			SELECT StaffID, StaffName, Working
            FROM dboOutletshared.tblStaffShared
            WHERE Working=1 AND [44]=1
            ORDER BY StaffName;
    	"));
    }

    public function paymentMethod()
    {
    	return DB::select(DB::raw("
			SELECT PmtMethodID, PmtMethod, Disc
			FROM dboOutletShared.tblPmtMethod
			WHERE (((PmtMethodID)=1) AND ((Disc)=0)) OR (((PmtMethodID)=3)) OR (((PmtMethodID)=4)) OR (((PmtMethodID)=5)) OR (((PmtMethodID)=2))
			ORDER BY PmtMethod;
    	"));
    }
    
    public function receiptTable()
    {
    	$collection = $this->storePrefix('tblCollection');
    	$payment = $this->storePrefix('tblPmtMethod');
    	$settlement = $this->storePrefix('tblSettlement');

        return DB::select(DB::raw("
            SELECT tblCollection.ReceiptNo, tblCollection.SaleID,
            -- SELECT tblCollection.CollectID, tblCollection.SaleID, tblCollection.ReceiptNo, tblCollection.CollectDate, 
            	CONVERT(VARCHAR, CAST(tblCollection.PmtAmount AS MONEY),1) PmtAmount,
                tblPmtMethod.PmtMethod
                -- tblCollection.PmtMethodID, tblPmtMethod.PmtMethod
            FROM $collection
                INNER JOIN $payment
            ON tblCollection.PmtMethodID = tblPmtMethod.PmtMethodID
            WHERE tblCollection.CollectDate =
            (
                SELECT SDate
                FROM $settlement
                WHERE Posted=0
            )
            -- WHERE tblCollection.CollectDate = '2017-04-24' -- tmp
            ORDER BY tblCollection.ReceiptNo
        "));
    }

    public function showTransaction($receipt)
    {
    	$sales = $this->storePrefix('tblSales');
    	$customer = $this->storePrefix('tblCustomer');
    	$salesTran = $this->storePrefix('tblSalesTran');
    	$payment = $this->storePrefix('tblPmtMethod');
    	$settlement = $this->storePrefix('tblSettlement');

        return DB::select(DB::raw("
            SELECT TOP 1 sales.SaleID, sales.ReceiptNo, sales.BranchID, FirstName, Surname, Block, Unit, Building, Street, PostCode, DOB, customer.HandPhone, 
                (DATENAME(weekday, SaleDate) + ', ' + DATENAME(month, SaleDate) + ' ' + DATENAME(day, SaleDate) + ', ' + DATENAME(year, SaleDate)) SaleDate,
                CONVERT(VARCHAR(15),CAST(SaleTime AS TIME),100) SaleTime,
                (DATENAME(weekday, sales.CollectDate) + ', ' + DATENAME(month, sales.CollectDate) + ' ' + DATENAME(day, sales.CollectDate) + ', ' + DATENAME(year, sales.CollectDate)) CollectDate,
                staff.StaffID, StaffName, TrayNo, PmtMethod,
                CONVERT(VARCHAR, CAST(Subtotal as MONEY),1) Subtotal, 
                CONVERT(VARCHAR, CAST(Deposit as MONEY),1) Deposit, 
                CONVERT(VARCHAR, CAST(Balance as MONEY),1) Balance
            FROM $sales AS sales
                JOIN $customer AS customer
            ON customer.CustID = sales.CustID
                JOIN dboOutletshared.tblStaffShared AS staff
            ON staff.StaffID = sales.StaffID
                JOIN $salesTran AS salesTran
            ON salesTran.SaleID = sales.SaleID
                JOIN $payment AS payment
            ON payment.PmtMethodID = sales.PmtMethodID
            WHERE sales.ReceiptNo=?
        "), [$receipt]);
    }

    public function showItems($receipt)
    {
    	$salesTran = $this->storePrefix('tblSalesTran');
    	$brand = $this->storePrefix('tblBrand');

        return DB::select(DB::raw("
            SELECT Brand, FullDescription, Qty,
                CONVERT(VARCHAR, CAST(Selling AS MONEY),1) Selling,
                CONVERT(VARCHAR, CAST(TranTotal AS MONEY),1) TranTotal
            FROM $salesTran AS salesTran
                JOIN $brand AS brand
            ON brand.BrandID = salesTran.BrandID
            WHERE ReceiptNo=?
            ORDER BY FullDescription ASC
        "), [$receipt]);
    }

    private function collectionLastID()
    {
        $result = (int) DB::table('dboBPP.tblCollection')->max('CollectID');
        return ++$result;
    }

    private function storePrefix($tableName)
    {
    	$authUser = auth()->user();
    	$table = $authUser->identifyTableName(request('table'));

    	return $table . '.' . $tableName;
    }

    public function receiptItemRemove()
    {
    	$table = $this->storePrefix('tblCollection');
    	$saleid = request('saleid');
    	$receipt = request('receipt');
    	array_add(request(), 'collectdate', date('Y-m-d'));

    	// remove data
    	$result = DB::table($table)->whereRaw('SaleID=? AND ReceiptNo=? AND CollectDate=?', [$saleid, $receipt, request('collectdate')])->delete();

        return response()->json(['isSuccess' => $result]);

    }
}
