<?php

namespace App\Http\Controllers\TableInvoice;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\CustomerTable;
use App\Models\PaymentMethod;
use App\Models\TableInvoice;
use Illuminate\Http\Request;

class TableInvoiceController extends Controller
{
    // TO create new invoice 
    public function new()
    {
        $data = [];
        $data['customers'] = Customer::all();
        $data['payments'] = PaymentMethod::all();
        $data['tables'] = CustomerTable::all();
        $data['banks'] = BankAccount::where('status',1)->get();
        return setPageContent('tableinvoice.new-table-invoice',$data);
    }

    public function draft(){
        $data = [];
        $data['title'] = 'Draft Invoice List';
        $data['tableinvoice'] = TableInvoice::with(['created_user','customer'])->where('warehousestore_id', getActiveStore()->id)->where('status','DRAFT')->where('invoice_date',date('Y-m-d'))->get();
        return setPageContent('invoice.draft-invoice',$data);
    }

    // show all table invoice draft that has a particular Table ID and has a section to complete the payment
    public function list() 
    {
        
    }

    // show Active tables 

}