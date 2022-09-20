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

                        <?php if(userCanView('bookings_and_reservation.create')): ?>
                            <span class="tools pull-right">
                                  <a  href="<?php echo e(route('bookings_and_reservation.create')); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Reservation / Booking</a>
                            </span>
                        <?php endif; ?>
                    </header>
                    <div class="panel-body">
                        <?php if(session('success')): ?>
                            <?php echo alert_success(session('success')); ?>

                        <?php elseif(session('error')): ?>
                            <?php echo alert_error(session('error')); ?>

                        <?php endif; ?>

                        <table class="table table-bordered table-responsive table convert-data-table table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Status</th>
                                <th>Nights</th>
                                <th>Rooms</th>
                                <th>Booking Date</th>
                                <th>Total</th>
                                <th>Total Paid</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                                $total =0;
                            ?>
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                    $total+=$booking->total_paid;
                                ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($booking->customer->firstname); ?> <?php echo e($booking->customer->lastname); ?></td>
                                    <td><?php echo e(str_date($booking->start_date)); ?></td>
                                    <td><?php echo e(str_date($booking->end_date)); ?></td>
                                    <td><?php echo label($booking->status->name, $booking->status->label); ?></td>
                                    <td><?php echo e($booking->no_of_days); ?></td>
                                    <td><?php echo e($booking->no_of_rooms); ?></td>
                                    <td><?php echo e(str_date($booking->booking_date)); ?></td>
                                    <td><?php echo e(number_format($booking->total)); ?></td>
                                    <td><?php echo e(number_format($booking->total_paid)); ?></td>
                                    <td><?php echo e($booking->user->name); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php if(userCanView('bookings_and_reservation.show')): ?>
                                                    <li><a href="<?php echo e(route('bookings_and_reservation.show',$booking->id)); ?>">View Booking</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('bookings_and_reservation.edit') && $booking->status->name!="Checked-out"): ?>
                                                    <li><a href="<?php echo e(route('bookings_and_reservation.edit',$booking->id)); ?>">Edit Booking</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('bookings_and_reservation.destroy') && $booking->status->name!="Checked-out"): ?>
                                                    <li><a href="<?php echo e(route('bookings_and_reservation.destroy',$booking->id)); ?>" class="confirm_action" data-msg="Are you sure, you want to delete this booking?">Delete Booking</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('bookings_and_reservation.make_payment') && ($booking->status->name!="Checked-out" && $booking->status->name!="Paid" )): ?>
                                                    <li><a href="<?php echo e(route('bookings_and_reservation.make_payment',$booking->id)); ?>">Add Payment</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('bookings_and_reservation.check_out') && $booking->status->name!="Checked-out"): ?>
                                                    <li><a href="<?php echo e(route('bookings_and_reservation.check_out',$booking->id)); ?>" class="confirm_action" data-msg="Are you sure, you want to checkout this booking?">Checkout Guest</a></li>
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
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Total</th>
                                <th><?php echo e(number_format($total,2)); ?></th>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/receptionist/bookings/list-reservation.blade.php ENDPATH**/ ?>