@extends('layouts.app')

@push('css')
    <link rel="stylesheet" href="{{ asset('bower_components/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">

    <link href="{{ asset('bower_components/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/datatables-tabletools/css/dataTables.tableTools.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/datatables-colvis/css/dataTables.colVis.css') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/datatables-responsive/css/responsive.dataTables.scss') }}" rel="stylesheet">
    <link href="{{ asset('bower_components/datatables-scroller/css/scroller.dataTables.scss') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="ui-container">
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $title }}
                        <form action=""  class="tools pull-right" style="margin-right: 80px" method="post">
                            {{ csrf_field() }}
                            <div class="row">
                                <div class="col-sm-3">
                                    <label>From</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="{{ $from }}" name="from" placeholder="From"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>To</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="{{ $to }}" name="to" placeholder="TO"/>
                                </div>
                                @if(in_array(auth()->user()->group_id, [1,2]))
                                    <div class="col-sm-3">
                                        <label>Department</label>
                                        <select class="form-control" name="department">
                                            @foreach($depts as $_dept)
                                                <option {{ $department == $_dept ? "selected" : "" }} value="{{ $_dept }}">{{ $_dept }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="col-sm-3">
                                        <label>Department</label>
                                        <input type="hidden" name="department" value="{{ auth()->user()->department }}"/>
                                    </div>
                                @endif
                                <div class="col-sm-3"><br/>
                                    <button type="submit" style="margin-top: 5px;" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </header>
                    <div class="panel-body">
                        @if(session('success'))
                            {!! alert_success(session('success')) !!}
                        @elseif(session('error'))
                            {!! alert_error(session('error')) !!}
                        @endif

                        <table class="table table-bordered table-responsive table convert-data-table table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Department</th>
                                <th>Table Name</th>
                                <th>Total Invoice</th>
                                <th>Total Items</th>
                                <th>Sub Total</th>
                                <th>Total Paid</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($tables as $table)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $department }}</td>
                                    <td>{{ $table->name }}</td>
                                    <td>{{ $table->invoices->count() }}</td>
                                    <td>{{ $table->invoice_items->count() }}</td>
                                    <td>{{ money($table->invoices->sum('sub_total'))  }}</td>
                                    <td>{{ money($table->invoices->sum('total_amount_paid')) }}</td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                @if(userCanView('invoiceandsales.print_table_pos'))
                                                    <li><a onclick="open_print_window(this); return false" href="{{ route('invoiceandsales.print_table_pos',$table->id) }}">Print Table Invoice</a></li>
                                                @endif
                                                @if(userCanView('invoiceandsales.pay_table_invoice'))
                                                    <li><a href="{{ route('invoiceandsales.pay_table_invoice',$table->id) }}">Pay & Complete Invoice(s)</a></li>
                                                @endif

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th>{{ money($tables->sum(function($table){
                                        return $table->invoices->sum('sub_total');
                                    })) }}</th>
                                <th>
                                    {{ money($tables->sum(function($table){
                                        return $table->invoices->sum('total_amount_paid');
                                    })) }}
                                </th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="{{ asset('bower_components/select2/dist/js/select2.min.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="{{ asset('assets/js/init-select2.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="{{ asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables-tabletools/js/dataTables.tableTools.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables-colvis/js/dataTables.colVis.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables-responsive/js/dataTables.responsive.js') }}"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="{{ asset('bower_components/datatables-scroller/js/dataTables.scroller.js') }}"></script>
    <script src="{{ asset('assets/js/init-datatables.js') }}"></script>
    <script  src="{{ asset('assets/js/init-datepicker.js') }}"></script>
@endpush
