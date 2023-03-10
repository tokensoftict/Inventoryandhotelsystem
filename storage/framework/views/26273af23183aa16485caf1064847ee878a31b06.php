<?php $__env->startPush('css'); ?>
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
                    <header class="panel-heading panel-border">
                        <?php echo e($title); ?>

                        <?php if(userCanView('user.group.create')): ?>
                            <span class="tools pull-right">
                                            <a  href="<?php echo e(route('stock.create')); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Stock</a>
                            </span>
                        <?php endif; ?>
                    </header>
                    <div class="panel-body">
                        <table class="table table-bordered table-responsive table convert-data-table table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Manufacturer</th>
                                <th>Selling Price</th>
                                <th>Cost Price</th>
                                <th>Created By</th>
                                <th>Last Updated</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $stocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stock): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($stock->name); ?></td>
                                    <td><?php echo e($stock->product_category ?  $stock->product_category->name : "No Category"); ?></td>
                                    <td><?php echo e($stock->manufacturer ?  $stock->manufacturer->name : "No Manufacturer"); ?></td>
                                    <td><?php echo e(number_format($stock->selling_price,2)); ?></td>
                                    <td><?php echo e(number_format($stock->cost_price,2)); ?></td>
                                    <td><?php echo e($stock->user ? $stock->user->name : ""); ?></td>
                                    <td><?php echo e($stock->last_updated ? $stock->last_updated->name  : ""); ?></td>
                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php if(userCanView('stock.edit')): ?>
                                                    <li><a href="<?php echo e(route('stock.edit',$stock->id)); ?>">Edit</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('stock.toggle')): ?>
                                                    <li><a href="<?php echo e(route('stock.toggle',$stock->id)); ?>"><?php echo e($stock->status == 0 ? 'Enabled' : 'Disabled'); ?></a></li>
                                                <?php endif; ?>
                                                    <?php if(userCanView('stock.stock_report')): ?>
                                                        <li><a href="<?php echo e(route('stock.stock_report',$stock->stock->id)); ?>">Product Report</a></li>
                                                    <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>


                    </div>
                </section>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables.net/js/jquery.dataTables.min.js')); ?>"></script>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-tabletools/js/dataTables.tableTools.js')); ?>"></script>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')); ?>"></script>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-colvis/js/dataTables.colVis.js')); ?>"></script>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-responsive/js/dataTables.responsive.js')); ?>"></script>
<script data-turbolinks-eval="false" data-turbo-eval="false"  src="<?php echo e(asset('bower_components/datatables-scroller/js/dataTables.scroller.js')); ?>"></script>
<script src="<?php echo e(asset('assets/js/init-datatables.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/stock/list-stock-disabled.blade.php ENDPATH**/ ?>