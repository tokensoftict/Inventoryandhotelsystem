

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
                                    <label>From</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="<?php echo e($from); ?>" name="from" placeholder="From"/>
                                </div>
                                <div class="col-sm-5">
                                    <label>To</label>
                                    <input type="text" class="form-control datepicker js-datepicker" data-min-view="2" data-date-format="yyyy-mm-dd" style="background-color: #FFF; color: #000;"  value="<?php echo e($to); ?>" name="to" placeholder="TO"/>
                                </div>
                                <div class="col-sm-2"><br/>
                                    <button type="submit" style="margin-top: 5px;" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-responsive table convert-data-table table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Date</th>
                                <th>Action Performed</th>
                                <th>User</th>
                            </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $activities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $activity): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($loop->iteration); ?></td>
                                        <td><?php echo e(str_date($activity->created_at)); ?></td>
                                        <td><?php echo e($activity->description); ?></td>
                                        <td><?php echo e($activity->causer->name); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                        <?php echo $activities->links(); ?>

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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\TokenSoft\Inventoryandhotelsystem\resources\views/access-control/audit_log.blade.php ENDPATH**/ ?>