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
                                <th>Action</th>
                            </tr>
                            @foreach ($customer_tables as $customer_table)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $customer_table->name }}</td>
                                    <td>{{$customer_table->department}}</td>
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
                                        <option>SELECT DEPARMTMENT</option>
                                        <option value="kitchen">KITCHEN</option>
                                        <option value="bar">BAR</option>
                                        <option value="receptionist">RECEPTIONIST</option>
                                        <option value="pamii">PAMII</option>
                                        <option value="morris_cafee">MORRIS CAFEE</option>
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
