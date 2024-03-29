    @extends('layouts.app')


@section('content')
    <div class="ui-container">
        <div class="row">
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $title }}
                        </header>
                        <div class="panel-body">
                            <form id="validate" action="{{ route('customer_table.update',$customer_table->id) }}" enctype="multipart/form-data" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" value="{{ old('name', $customer_table->name) }}" required  class="form-control" name="name" placeholder="Product Category"/>
                                    @if ($errors->has('name'))
                                        <label for="name-error" class="error"
                                               style="display: inline-block;">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Department</label>
                                    <select class="form-control" name="department" required>
                                        <option>Select Department</option>
                                        <option {{ old('department', $customer_table->department) == 'KITCHEN' ? 'selected' : "" }}>KITCHEN</option>
                                        <option {{ old('department', $customer_table->department) == 'BAR' ? 'selected' : "" }}>BAR</option>
                                        <option {{ old('department', $customer_table->department) == 'RECEPTIONIST' ? 'selected' : "" }}>RECEPTIONIST</option>
                                        <option {{ old('department', $customer_table->department) == 'PAMII' ? 'selected' : "" }}>PAMII</option>
                                        <option {{ old('department', $customer_table->department) == 'MORRIS CAFEE' ? 'selected' : "" }}>MORRIS CAFEE</option>
                                    </select>
                                    @if ($errors->has('name'))
                                        <label for="name-error" class="error"
                                            style="display: inline-block;">{{ $errors->first('name') }}</label>
                                    @endif
                                </div>
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Update</button>
                                </div>
                                <br/> <br/>
                            </form>
                        </div>
                    </section>
                </div>
        </div>
    </div>

@endsection



