<?php

namespace App\Http\Controllers\TableInvoice;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\CustomerTable;
use App\Models\PaymentMethod;
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
    // show all table invoice
    public function list() {
        
    }

    // show Active tables 
    public function active() {

    }
}