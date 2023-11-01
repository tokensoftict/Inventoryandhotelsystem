<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\CustomerTable;
use Illuminate\Http\Request;

class CustomerTableController extends Controller
{
    public function index()
    {
        $data['title'] = "List Tables";
        $data['title2'] = "Add Table";

        $data['customer_tables'] = CustomerTable::all();

        return setPageContent('settings.customer_table.list-tables', $data);
    }


    public function create()
    {
    }



    public function store(Request $request)
    {

        $request->validate(CustomerTable::$validate);

        $data = $request->only(CustomerTable::$fields);

        // dd($data);
        // $data['status'] = 1;
        
        CustomerTable::create($data);

        return redirect()->route('customer_table.index')->with('success', 'Expenses type as been created successful!');
    }


    public function toggle($id)
    {

        $this->toggleState(CustomerTable::find($id));

        return redirect()->route('customer_table.index')->with('success', 'Operation successful!');
    }


    public function edit($id)
    {
        $data['title'] = "Update Customer Table";
        $data['customer_table'] = CustomerTable::find($id);
        return setPageContent('settings.customer_table.edit', $data);
    }

    public function update(Request $request, $id)
    {

        $request->validate(CustomerTable::$validate);

        $data = $request->only(CustomerTable::$fields);

        CustomerTable::find($id)->update($data);

        return redirect()->route('customer_table.index')->with('success', 'Expenses Type as been updated successful!');
    }
}
