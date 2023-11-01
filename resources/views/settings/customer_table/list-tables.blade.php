@extends('layouts.app')


@section('content')
    <div class="ui-container">
        <div class="row">
            <div class="col-md-8">
                <section class="panel">
                    <header class="panel-heading">
                        {{ $title }}
                    </header>
                    <div class="panel-body">
                        @if (session('success'))
                            {!! alert_success(session('success')) !!}
                        @elseif(session('error'))
                            {!! alert_error(session('error')) !!}
                        @endif

                        <table class="table table-hover table-hover">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            @foreach ($customer_tables as $customer_table)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer_table->name }}</td>
                                    <td>{{$customer_table->department}}</td>
                                    <td>{{ \Illuminate\Support\Str::title($customer_table->status->value) }}</td>
                                    <td>
                                        @if (userCanView('customer_table.edit'))
                                            <a href="{{ route('customer_table.edit', $customer_table->id) }}"
                                                class="btn btn-success btn-sm">Edit</a>
                                        @endif
                                </tr>
                            @endforeach
                        </table>

                    </div>
                </section>
            </div>

            @if (userCanView('customer_table.create'))
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $title2 }}
                        </header>
                        <div class="panel-body">
                            <form id="validate" action="{{ route('customer_table.store') }}" enctype="multipart/form-data"
                                method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" value="{{ old('name') }}" required class="form-control"
                                        name="name" placeholder="Name" />
                                    @if ($errors->has('name'))
                                        <label for="name-error" class="error"
                                            style="display: inline-block;">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department">
                                        <option>Select Department</option>
                                        <option>KITCHEN</option>
                                        <option>BAR</option>
                                        <option>RECEPTIONIST</option>
                                        <option>PAMII</option>
                                        <option>MORRIS CAFEE</option>
                                    </select>
                                    @if ($errors->has('name'))
                                        <label for="name-error" class="error"
                                            style="display: inline-block;">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                                <br /> <br />
                            </form>
                        </div>
                    </section>
                </div>
            @endif
        </div>
    </div>

@endsection
