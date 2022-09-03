<?php

namespace App\Http\Controllers\StockManager;

use App\Http\Controllers\Controller;
use App\Models\InvoiceItem;
use App\Models\Manufacturer;
use App\Models\ProductCategory;
use App\Models\PurchaseOrderItem;
use App\Models\ReturnLog;
use App\Models\Status;
use App\Models\Stock;
use App\Models\Stockbatch;
use App\Models\StockLog;
use App\Models\StockLogItem;
use App\Models\StockTransferItem;
use App\Models\Supplier;
use App\Models\Warehousestore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{


    public function index(){

        $data['title'] = "Stock List(s)";
        $data['stocks'] = Stock::with(['manufacturer','product_category','user','last_updated'])->where('status',1);
        return setPageContent("stock.list-stock",$data);
    }


    public function create(){
        $data['title'] = "New Stock";
        $data['stock'] = new Stock();
        $data['manufactures'] = Manufacturer::where('status',1)->get();
        $data['categories'] = ProductCategory::where('status',1)->get();
        $data['suppliers'] = Supplier::where('status',1)->get();
        return setPageContent("stock.form",$data);
    }

    public function store(Request $request){

        $validate = Stock::$validation;

        $file = $request->file('image');

        if($file){
            $validate['image'] = 'mimes:jpeg,jpg,png,gif|required|max:10000';
        }

        $request->validate($validate);

        $stock_data = $request->only(Stock::$field);

        if ($file) {
            $imageName = time().'.'. $request->image->getClientOriginalExtension();

            $request->logo->move(public_path('img'), $imageName);

            $stock_data['image'] = $imageName;

        }

        //validate image

        $stock = Stock::create( $stock_data);

        $batch = $request->get('stock_batch');

        if($request->get('stock_batch') && !empty($batch['quantity'])) {
            $batch['received_date'] = date('Y-m-d');
            $stock->stockbatches()->create($batch);
        }


        return redirect()->route('stock.create')->with('success','Stock has been created successful!');
    }


    public function show(){

    }

    public function edit($id){
        $data['title'] = "New Stock";
        $data['stock'] =  Stock::find($id);
        $data['manufactures'] = Manufacturer::where('status',1)->get();
        $data['categories'] = ProductCategory::where('status',1)->get();
        $data['suppliers'] = Supplier::where('status',1)->get();
        return setPageContent("stock.form",$data);
    }

    public function update(Request $request,$id){

        $stock = Stock::findorfail($id);

        $validate = Stock::$validation;

        $file = $request->file('image');

        if($file){
            $validate['image'] = 'mimes:jpeg,jpg,png,gif|required|max:10000';
        }

        $request->validate($validate);

        $stock_data = $request->only(Stock::$field);

        if ($file) {
            $imageName = time().'.'. $request->image->getClientOriginalExtension();

            $request->logo->move(public_path('img'), $imageName);

            $stock_data['image'] = $imageName;

        }

        if(!empty( $stock->image)) {
            @unlink(public_path('img/' . $stock->image));
        }

        $stock->update($stock_data);

        return redirect()->route('stock.index')->with('success','Stock has been updated successful!');

    }


    public function available(){

        $sql = "";
        $store = getActiveStore();

        $sql .= "SUM(" . $store->packed_column . ") as " . $store->packed_column . ",";
        $sql .= "SUM(" . $store->yard_column . ") as " . $store->yard_column . ",";

        $sql = rtrim($sql,", ");

        $available = Stockbatch::select(
            'stock_id',
            DB::raw($sql)
        )
            ->with(['stock'])
            ->whereHas('stock',function($query){
                $query->where('status',1);
            })
            ->groupBy('stock_id')
            ->get();


        $data['batches'] = $available;
        $data['title'] = "Available Stock";
        $data['store'] = $store;

        return setPageContent("stock.list-available",$data);
    }

    public function toggle($id){
        $this->toggleState(Stock::find($id));

        return redirect()->route('stock.index')->with('success','Operation successful!');
    }

    public function disabled(){
        $data['title'] = "Disabled Stock List(s)";
        $data['stocks'] = Stock::with(['manufacturer','product_category','user','last_updated'])->where('status',0);
        return setPageContent("stock.list-stock-disabled",$data);
    }


    public function conversion_of(Request $request){
        $data['title'] = "Stock Conversion";
        $data['stocks'] = Stock::where('status',1)->where('type','PACKED')->get();
        $data['select_stock'] = 0;
        if(($request->method() == "POST") &&  isset($request->tt_bundle)){
            return Stock::convertStock($request);
        }else if(($request->method() == "POST") &&  !isset($request->tt_bundle)){
            $data['convert_stock'] = Stock::find($request->select_stock);
            $data['select_stock'] = $request->select_stock;
        }
        return setPageContent("stock.convert_stock",$data);
    }


    public function add_log(Request $request){

        if($request->getMethod() == "POST"){

            return StockLogItem::createStockLog($request);
        }
        $data['title'] = "New Stock Log";
        $data['title2'] = "Today's Stock Log";
        $data['stores'] = Warehousestore::all();
        $data['logs'] = StockLogItem::with(['user','stock','operation','warehousestore'])->where('log_date',dailyDate())->orderBy('log_date','DESC')->get();
        return setPageContent("stock.stocklog.form",$data);
    }

    public function usage_log_report(Request $request)
    {
        $data['title'] = "Stock Log Report";
        if($request->get('from') && $request->get('to')){
            $data['from']  = $request->get('from');
            $data['to']  = $request->get('to');
        }else{
            $data['from']  = date('Y-m-01');
            $data['to']  = date('Y-m-t');
        }

        $data['logs'] = StockLogItem::with(['user','stock','operation','warehousestore'])->whereBetween('log_date',[$data['from'], $data['to']])->get();
        return setPageContent("stock.stocklog.stocklog_report",$data);
    }



    public function edit_log(Request $request, $id)
    {
        $data['title'] = "Edit Stock Log";
        $data['log'] = StockLogItem::with(['user','stock','operation'])->find($id);
        $data['stores'] = Warehousestore::all();
        return setPageContent("stock.stocklog.edit_form",$data);
    }

    public function update_log(Request $request, $id)
    {
        return StockLogItem::updateStockLog($id, $request);
    }

    public function delete_log( $id)
    {
        $log = StockLogItem::with(['user','stock','operation','warehousestore'])->find($id);

        foreach ($log->stockLogOperation()->get() as $operation)
        {
            $operation->returnStockBack();
            $operation->delete();
        }

        $log->delete();

        return redirect()->route('stocklog.usage_log_report')->with('success','Stock Log has been deleted successfully!');
    }



    public function stock_report(Request $request, $id){
        if($request->get('from') && $request->get('to')){
            $data['from']  = $request->get('from');
            $data['to']  = $request->get('to');
        }else{
            $data['from']  = date('Y-m-01');
            $data['to']  = date('Y-m-t');
        }

        $data['sales'] = InvoiceItem::where('stock_id',$id)->whereBetween('invoice_date',[ $data['from'] , $data['to'] ])->get();
        $data['transfers'] = StockTransferItem::where('stock_id',$id)->whereBetween('transfer_date',[ $data['from'] , $data['to']])->get();
        $data['purchases'] = PurchaseOrderItem::where('stock_id',$id)->whereBetween('created_at',[ $data['from'] , $data['to']])->get();
        $data['returns'] = ReturnLog::where('stock_id',$id)->whereBetween('date_added',[ $data['from'] , $data['to']])->get();
        $data['stock'] = Stock::find($id);
        $data['title'] = "Stock / Product Report for ".$data['stock']->name;
        return setPageContent("stock.product_report",$data);
    }


    public function quick(Request $request)
    {
        $data['title'] = "Quick Adjust Quantity";
        $data['stocks'] = Stock::where('status',1)->get();
        $data['select_stock'] = 0;

        if(($request->method() == "POST") &&  isset($request->yard_qty)){
            return Stock::adjustStockQuantity($request);
        }else if(($request->method() == "POST") &&  !isset($request->yard_qty)){
            $data['convert_stock'] = Stock::find($request->select_stock);
            $countBatch = $data['convert_stock']->stockBatches()->orderBy("expiry_date", "DESC")->count();
            if($countBatch == 0) redirect()->route('stock.quick')->with('error','Stock Initial Purchase Order not found, Please create Purchase order for product to adjust');
            $data['select_stock'] = $request->select_stock;
        }

        return setPageContent("stock.quick_adjust_qty",$data);
    }


}
