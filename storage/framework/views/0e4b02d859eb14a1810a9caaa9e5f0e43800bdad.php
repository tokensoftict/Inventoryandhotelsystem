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


                        <span class="tools pull-right">
                            <?php if(userCanView('bookings_and_reservation.edit',$booking->id)): ?>
                                <a  href="<?php echo e(route('bookings_and_reservation.edit',$booking->id)); ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit Booking</a>
                                &nbsp; &nbsp;
                            <?php endif; ?>
                            <?php if(userCanView('bookings_and_reservation.destroy',$booking->id)): ?>
                                <a  href="<?php echo e(route('bookings_and_reservation.destroy',$booking->id)); ?>" class="btn btn-sm btn-danger confirm_action" data-msg="Are you sure, you want to delete this booking?"><i class="fa fa-trash"></i> Delete Booking</a>
                            <?php endif; ?>

                            <?php if(userCanView('bookings_and_reservation.make_payment') && ($booking->status->name!="Checked-out" && $booking->status->name!="Paid" )): ?>
                                <a class="btn btn-sm btn-primary" href="<?php echo e(route('bookings_and_reservation.make_payment',$booking->id)); ?>">Add Payment</a>
                            <?php endif; ?>
                            <?php if(userCanView('bookings_and_reservation.check_out') && $booking->status->name!="Checked-out"): ?>
                                <a class="btn btn-sm btn-success confirm_action" data-msg="Are you sure, you want to checkout this booking?" href="<?php echo e(route('bookings_and_reservation.check_out',$booking->id)); ?>">Checkout Guest</a>
                            <?php endif; ?>

                            </span>
                    </header>
                    <div class="panel-body">
                        <?php if(session('success')): ?>
                            <?php echo alert_success(session('success')); ?>

                        <?php elseif(session('error')): ?>
                            <?php echo alert_error(session('error')); ?>

                        <?php endif; ?>

                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Customer Name</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->firstname); ?> <?php echo e($booking->customer->lastname); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Start Date</label><br/>
                                    <span class="text-md"><?php echo e(str_date($booking->start_date)); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>End Date</label><br/>
                                    <span class="text-md"><?php echo e(str_date($booking->end_date)); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Status</label><br/>
                                    <span class="text-md"><?php echo label($booking->status->name, $booking->status->label); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 16px">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>No of Nights</label><br/>
                                    <span class="text-md">  <?php echo e($booking->no_of_days); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>No of Rooms</label><br/>
                                    <span class="text-md">  <?php echo e($booking->no_of_rooms); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Booking Date</label><br/>
                                    <span class="text-md"><?php echo e(str_date($booking->booking_date)); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Total</label><br/>
                                    <span class="text-md"><?php echo e(number_format($booking->total,2)); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 16px">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Total Paid</label><br/>
                                    <span class="text-md"> <?php echo e(number_format($booking->total_paid,2)); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Created By</label><br/>
                                    <span class="text-md">  <?php echo e($booking->user->name); ?></span>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <hr/>
                                <h4>Customer Information</h4>
                                <hr/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Customer Name</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->firstname); ?> <?php echo e($booking->customer->lastname); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Address</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->address); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Email address</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->email); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Phone Number</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->phone_number); ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 16px">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>NOK Full Name</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->nok_firstname); ?> <?php echo e($booking->customer->nok_lastname); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>NOK Phone Number</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->nok_phone_number); ?></span>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Nationality</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->nationality); ?></span>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label>Passport Number / Expiry Date</label><br/>
                                    <span class="text-md"><?php echo e($booking->customer->passport_no); ?> / <?php echo e($booking->customer->passport_expire_date); ?></span>
                                </div>
                            </div>
                        </div>


                        <div class="row" style="margin-top: 16px">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Occupation</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->occupation); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Purpose Of Visit</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->purpose_of_visit); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Vehicle Reg Number</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->vehicle_reg_number); ?></span>
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Arriving From</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->arriving_from); ?></span>
                                    </div>
                                </div>
                            </div>

                        <div class="row" style="margin-top: 16px">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>City</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->city); ?></span>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>State</label><br/>
                                        <span class="text-md"><?php echo e($booking->customer->state); ?></span>
                                    </div>
                                </div>

                            </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <hr/>
                                <h4>Room Information</h4>
                                <hr/>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 16px">
                            <div class="col-md-12">
                                <table class="table table-bordered table-responsive table convert-data-table table-striped" style="font-size: 12px">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Room Name</th>
                                        <th>Price</th>
                                        <th>No of Nights</th>
                                        <th>Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $booking->booking_reservation_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td><?php echo e($loop->iteration); ?></td>
                                            <td><?php echo e($item->room->name); ?></td>
                                            <td><?php echo e(number_format($item->price,2)); ?></td>
                                            <td><?php echo e($item->noOfDays); ?></td>
                                            <td><?php echo e(number_format($item->total,2)); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Sub Total</th>
                                        <th><?php echo e(number_format($booking->total,2)); ?></th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>Total</th>
                                        <th><?php echo e(number_format($booking->total,2)); ?></th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <hr/>
                                    <h4>Payment Information</h4>
                                    <hr/>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-responsive table convert-data-table table-striped" id="invoice-list" style="font-size: 12px">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Customer</th>
                                            <th>Store</th>
                                            <th>Method</th>
                                            <th>Invoice / Receipt Number</th>
                                            <th>Sub Total</th>
                                            <th>Total Paid</th>
                                            <th>Payment Time</th>
                                            <th>Payment Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $total=0;
                                        ?>
                                        <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($loop->iteration); ?></td>
                                                <td><?php echo e($payment->customer->firstname); ?> <?php echo e($payment->customer->lastname); ?></td>
                                                <td><?php echo e($payment->warehousestore->name); ?></td>
                                                <td><?php echo e($payment->payment_method->name); ?></td>
                                                <td><?php echo e($payment->invoice->invoice_paper_number); ?></td>
                                                <td><?php echo e(number_format($payment->amount,2)); ?></td>
                                                <td><?php echo e(number_format($payment->amount,2)); ?></td>
                                                <td><?php echo e(date("h:i a",strtotime($payment->payment->payment_time))); ?></td>
                                                <td><?php echo e(convert_date($payment->payment->payment_date)); ?></td>
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
                                            <th><?php echo e(number_format($payments->sum('amount'),2)); ?></th>
                                            <th><?php echo e(number_format($payments->sum('amount'),2)); ?></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/receptionist/bookings/view_booking.blade.php ENDPATH**/ ?>