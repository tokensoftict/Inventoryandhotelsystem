<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/select2/dist/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')); ?>">

    <link href="<?php echo e(asset('bower_components/datatables/media/css/jquery.dataTables.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('bower_components/datatables-tabletools/css/dataTables.tableTools.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('bower_components/datatables-colvis/css/dataTables.colVis.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('bower_components/datatables-responsive/css/responsive.dataTables.scss')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('bower_components/datatables-scroller/css/scroller.dataTables.scss')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-md-12">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo e($title); ?>


                        <form action=""  class="tools pull-right" style="margin-right: 80px" method="post">
                            <?php echo e(csrf_field()); ?>

                            <div class="row">
                                <div class="col-sm-3">
                                    <label>From</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="<?php echo e($from); ?>" name="from" placeholder="From"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>To</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="<?php echo e($to); ?>" name="to" placeholder="TO"/>
                                </div>
                                <div class="col-sm-3">
                                    <label>Search Product</label>
                                    <select id="products" class="form-control" name="product">
                                       <option selected value="<?php echo e($product); ?>"><?php echo e($product_name); ?></option>
                                    </select>
                                </div>
                                <div class="col-sm-3"><br/>
                                    <button type="submit" style="margin-top: 5px;" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>

                    </header>
                    <div class="panel-body">
                        <?php if(session('success')): ?>
                            <?php echo alert_success(session('success')); ?>

                        <?php elseif(session('error')): ?>
                            <?php echo alert_error(session('error')); ?>

                        <?php endif; ?>
                        <table class="table table-bordered table-responsive table convert-data-table table-striped" id="invoice-list" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Invoice/Receipt No</th>
                                <th>Customer</th>
                                <th>Stock</th>
                                <th>Qty Sold</th>
                                <th>Total Cost Price</th>
                                <th>Total Selling Price</th>
                                <th>Profit</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $total_cost =0;
                                $total_selling =0;
                                $total_profit =0;
                            ?>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $total_cost+=($invoice->quantity * $invoice->cost_price);
                                    $total_selling+=($invoice->quantity * $invoice->selling_price);
                                    $total_profit += (($invoice->quantity * $invoice->selling_price)-($invoice->quantity * $invoice->cost_price));
                                ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($invoice->invoice->invoice_paper_number); ?></td>
                                    <td><?php echo e($invoice->customer->firstname); ?> <?php echo e($invoice->customer->lastname); ?></td>
                                    <td><?php echo e($invoice->stock->name); ?></td>
                                    <td><?php echo e($invoice->quantity); ?></td>
                                    <td><?php echo e(number_format(($invoice->quantity * $invoice->cost_price),2)); ?></td>
                                    <td><?php echo e(number_format(($invoice->quantity * $invoice->selling_price),2)); ?></td>
                                    <td><?php echo e(number_format((($invoice->quantity * $invoice->selling_price)-($invoice->quantity * $invoice->cost_price)),2)); ?></td>
                                    <td><?php echo invoice_status($invoice->status); ?></td>
                                    <td><?php echo e(convert_date2($invoice->invoice->invoice_date)); ?></td>
                                    <td><?php echo e(date("h:i a",strtotime($invoice->invoice->sales_time))); ?></td>
                                    <td><?php echo e($invoice->invoice->created_user->name); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php if(userCanView('invoiceandsales.view')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.view',$invoice->invoice->id)); ?>">View Invoice</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.pos_print')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.pos_print',$invoice->invoice->id)); ?>">Print Invoice Pos</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.print_afour')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.print_afour',$invoice->invoice->id)); ?>">Print Invoice A4</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.print_way_bill')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.print_way_bill',$invoice->invoice->id)); ?>">Print Waybill</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?php echo e(number_format($total_cost,2)); ?></th>
                                <th><?php echo e(number_format($total_selling,2)); ?></th>
                                <th><?php echo e(number_format($total_profit,2)); ?></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="<?php echo e(asset('bower_components/select2/dist/js/select2.min.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="<?php echo e(asset('assets/js/init-select2.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false" src="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')); ?>"></script>

    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-tabletools/js/dataTables.tableTools.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-colvis/js/dataTables.colVis.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-responsive/js/dataTables.responsive.js')); ?>"></script>
    <script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-scroller/js/dataTables.scroller.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/init-datatables.js')); ?>"></script>
    <script  src="<?php echo e(asset('assets/js/init-datepicker.js')); ?>"></script>
    <script>
        $(document).ready(function(e){
            var path = "<?php echo e(route('findselectstock')); ?>?select2=yes";
            var select =  $('#products').select2({
                placeholder: 'Search for product',
                ajax: {
                    url: path,
                    dataType: 'json',
                    delay: 250,
                    data: function (data) {
                        return {
                            searchTerm: data.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results:response
                        };
                    },
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/invoicereport/product_monthly.blade.php ENDPATH**/ ?>