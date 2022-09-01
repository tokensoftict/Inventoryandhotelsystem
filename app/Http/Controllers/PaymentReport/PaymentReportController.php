<?php

namespace App\Http\Controllers\PaymentReport;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodTable;
use Illuminate\Http\Request;

class PaymentReportController extends Controller
{

    public function daily_payment_reports(Request $request)
    {
        if($request->get('date')){
            $data['date'] = $request->get('date');
        }else{
            $data['date'] = dailyDate();
        }
        $data['title'] = "Daily Payment Report";
        $data['payments'] = Payment::with(['warehousestore','customer','user','payment_method_tables','invoice'])->where('warehousestore_id',getActiveStore()->id)->where('payment_date', $data['date'])->orderBy('id','DESC')->get();
        return setPageContent('paymentreport.daily_payment_reports',$data);
    }

    public function monthly_payment_reports(Request $request)
    {
        if($request->get('from') && $request->get('to')){
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
        }else{
            $data['from'] = date('Y-m-01');
            $data['to'] = date('Y-m-t');
        }

        $data['title'] = "Monthly Payment Report";

        $data['payments'] = Payment::with(['warehousestore','customer','user','payment_method_tables','invoice'])->where('warehousestore_id',getActiveStore()->id)->whereBetween('payment_date', [$data['from'],$data['to']])->orderBy('id','DESC')->get();
        return setPageContent('paymentreport.monthly_payment_reports',$data);
    }

    public function monthly_payment_report_by_method(Request $request)
    {
        if($request->get('from') && $request->get('to')){
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
            $data['payment_method'] = $request->get('payment_method');
        }else{
            $data['from'] = date('Y-m-01');
            $data['to'] = date('Y-m-t');
            $data['payment_method'] = 1;
        }
        $data['payments'] = PaymentMethodTable::with(['warehousestore','payment','customer','user','payment_method','invoice'])->where('payment_method_id', $data['payment_method'])->where('warehousestore_id',getActiveStore()->id)->whereBetween('payment_date', [$data['from'],$data['to']])->orderBy('id','DESC')->get();
        $data['title'] = "Monthly Payment Report By Payment Method";
        $data['pmthods'] = PaymentMethod::all();
        return setPageContent('paymentreport.monthly_payment_reports_by_method',$data);
    }

    public function payment_analysis(Request $request)
    {
        if($request->get('date')){
            $data['date'] = $request->get('date');
        }else{
            $data['date'] = dailyDate();
        }
        $data['title'] = "Payment Analysis";

        $data['payment_methods'] = PaymentMethod::all();

        return setPageContent('paymentreport.payment_analysis',$data);
    }


    public function income_analysis(Request $request)
    {
        if($request->get('from') && $request->get('to')){
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
            $data['department'] = $request->get('department');
        }else{
            $dpt_key = array_keys(config('app.departments.'.config('app.store')));
            $data['from'] = date('Y-m-01');
            $data['to'] = date('Y-m-t');
            $data['department'] = config('app.departments.'.config('app.store'))[$dpt_key[0]];
        }

        $data['expenses'] = Expense::with(['expenses_type','user'])->whereBetween('expense_date',[ $data['from'], $data['to']])->get();
        $data['payments'] = PaymentMethodTable::with(['warehousestore','payment','customer','user','payment_method','invoice'])->where('warehousestore_id',getActiveStore()->id)->whereBetween('payment_date', [$data['from'],$data['to']])->orderBy('id','DESC')->get();

        $data['title'] = "Income Analysis";
        $data['depts'] = config('app.departments.'.config('app.store'));
        return setPageContent('paymentreport.income_analysis',$data);
    }



    public function income_analysis_by_department(Request $request)
    {
        if($request->get('from') && $request->get('to')){
            $data['from'] = $request->get('from');
            $data['to'] = $request->get('to');
            $data['department'] = $request->get('department');
        }else{
            $dpt_key = array_keys(config('app.departments.'.config('app.store')));
            $data['from'] = date('Y-m-01');
            $data['to'] = date('Y-m-t');
            $data['department'] = config('app.departments.'.config('app.store'))[$dpt_key[0]];
        }

        $data['expenses'] = Expense::with(['expenses_type','user'])->where('department', $data['department'])->whereBetween('expense_date',[ $data['from'], $data['to']])->get();
        $data['payments'] = PaymentMethodTable::with(['warehousestore','payment','customer','user','payment_method','invoice'])->where('department', $data['department'])->where('warehousestore_id',getActiveStore()->id)->whereBetween('payment_date', [$data['from'],$data['to']])->orderBy('id','DESC')->get();

        $data['title'] = "Income Analysis By Department";
        $data['depts'] = config('app.departments.'.config('app.store'));
        return setPageContent('paymentreport.income_analysis_by_department',$data);
    }

}
