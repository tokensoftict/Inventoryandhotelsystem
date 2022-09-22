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
                                <div class="col-sm-5">
                                    <label>Select Date</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="<?php echo e($date); ?>" name="date" placeholder="Date"/>
                                </div>
                                <div class="col-sm-5">
                                    <label>Select Status</label>
                                    <select class="form-control" name="status">
                                        <option <?php echo e($status == "COMPLETE" ? "selected" : ""); ?> value="COMPLETE">COMPLETE</option>
                                        <option <?php echo e($status == "DRAFT" ? "selected" : ""); ?> value="DRAFT">DRAFT</option>
                                    </select>
                                </div>
                                <div class="col-sm-2"><br/>
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
                                <th>Status</th>
                                <th>Sub Total</th>
                                <th>Total Paid</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $total = 0;
                            ?>
                            <?php $__currentLoopData = $invoices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $invoice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $total += $invoice->total_amount_paid;
                                ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($invoice->invoice_paper_number); ?></td>
                                    <td><?php echo e($invoice->customer->firstname); ?> <?php echo e($invoice->customer->lastname); ?></td>
                                    <td><?php echo invoice_status($invoice->status); ?></td>
                                    <td><?php echo e(number_format($invoice->sub_total,2)); ?></td>
                                    <td><?php echo e(number_format($invoice->total_amount_paid,2)); ?></td>
                                    <td><?php echo e(convert_date2($invoice->invoice_date)); ?></td>
                                    <td><?php echo e(date("h:i a",strtotime($invoice->sales_time))); ?></td>
                                    <td><?php echo e($invoice->created_user->name); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php if(userCanView('invoiceandsales.view')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.view',$invoice->id)); ?>">View Invoice</a></li>
                                                <?php endif; ?>
                                                    <?php if(userCanView('invoiceandsales.edit') && $invoice->sub_total > -1 && $invoice->status =="DRAFT"): ?>
                                                        <li><a href="<?php echo e(route('invoiceandsales.edit',$invoice->id)); ?>">Edit Invoice</a></li>
                                                    <?php endif; ?>
                                                    <?php if(userCanView('invoiceandsales.destroy') && $invoice->status =="DRAFT"): ?>
                                                        <li><a href="<?php echo e(route('invoiceandsales.destroy',$invoice->id)); ?>">Delete Invoice</a></li>
                                                    <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.pos_print')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.pos_print',$invoice->id)); ?>">Print Invoice Pos</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.print_afour')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.print_afour',$invoice->id)); ?>">Print Invoice A4</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('invoiceandsales.print_way_bill')): ?>
                                                    <li><a href="<?php echo e(route('invoiceandsales.print_way_bill',$invoice->id)); ?>">Print Waybill</a></li>
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
                                <th><?php echo e(number_format($invoices->sum('sub_total'),2)); ?></th>
                                <th><?php echo e(number_format($total,2)); ?></th>
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/invoicereport/daily.blade.php ENDPATH**/ ?>