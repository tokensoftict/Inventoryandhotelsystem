<?php

namespace App\Http\Controllers\TableInvoice;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\Customer;
use App\Models\CustomerTable;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\TableInvoice;
use App\Models\Invoice;
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
        $data['banks'] = BankAccount::where('status', 1)->get();
        return setPageContent('tableinvoice.new-table-invoice', $data);
    }

    public function draft()
    {
        $data = [];
        $data['title'] = 'Draft Invoice List';
        $data['tableinvoices'] = TableInvoice::with(['created_user', 'customer'])->where('warehousestore_id', getActiveStore()->id)->where('status', 'DRAFT')->where('invoice_date', date('Y-m-d'))->get();
        return setPageContent('tableinvoice.draft-invoice', $data);
    }

    public function create(Request $request)
    {

        $reports = TableInvoice::validateInvoiceProduct(json_decode($request->get('data'), true), 'quantity');    // validate products if the quantity is okay


        if ($reports['status'] == true) return response()->json(['status' => false, 'error' => $reports['errors']]);

        $invoice = TableInvoice::createInvoice($request, $reports, false);


        $success_view = view('invoice.success', ['invoice_id' => $invoice->id])->render();

        return json(['status' => true, 'html' => $success_view]);
    }

}
