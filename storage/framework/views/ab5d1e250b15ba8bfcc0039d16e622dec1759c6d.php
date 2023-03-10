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

                        <?php if(userCanView('stock.create')): ?>
                            <span class="tools pull-right">
                                            <a  href="<?php echo e(route('stock.create')); ?>" class="btn btn-primary"><i class="fa fa-plus"></i> New Stock</a>
                            </span>
                        <?php endif; ?>
                    </header>
                    <div class="panel-body">
                        <table class="table <?php echo e(config('app.store') == "inventory" ? "" : 'convert-data-table'); ?> table-bordered table-responsive table-striped" style="font-size: 12px">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Product Type</th>
                                <th><?php echo e($store->name); ?> Quantity</th>
                                <?php if(config('app.store') == "inventory"): ?>
                                    <th><?php echo e($store->name); ?> Yards Quantity</th>
                                <?php endif; ?>
                                <th>Selling Price</th>
                                <th>Cost Price</th>
                                <?php if(config('app.store') == "inventory"): ?>
                                <th>Yard Selling Price</th>
                                <th>Yard Cost Price</th>
                                <?php endif; ?>
                                <?php if(config('app.store') == "hotel"): ?>
                                 <th>VIP Selling Price</th>
                                <?php endif; ?>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $batches; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $batch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($batch->stock->name); ?></td>
                                    <td><?php echo e($batch->stock->type); ?></td>
                                    <td><?php echo e($batch->stock->available_quantity); ?></td>
                                    <?php if(config('app.store') == "inventory"): ?>
                                        <td><?php echo e($batch->stock->available_yard_quantity); ?></td>
                                    <?php endif; ?>
                                    <td><?php echo e(number_format($batch->stock->selling_price,2)); ?></td>
                                    <td><?php echo e(number_format($batch->stock->cost_price,2)); ?></td>
                                    <?php if(config('app.store') == "inventory"): ?>
                                    <td><?php echo e(number_format($batch->stock->yard_selling_price,2)); ?></td>
                                    <td><?php echo e(number_format($batch->stock->yard_cost_price,2)); ?></td>
                                    <?php endif; ?>
                                    <?php if(config('app.store') == "hotel"): ?>
                                        <td><?php echo e(number_format($batch->stock->vip_selling_price,2)); ?></td>
                                    <?php endif; ?>

                                    <td>
                                        <div class="btn-group">
                                            <button data-toggle="dropdown" class="btn btn-success dropdown-toggle btn-xs" type="button" aria-expanded="false">Action <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <?php if(userCanView('stock.edit')): ?>
                                                    <li><a href="<?php echo e(route('stock.edit',$batch->stock->id)); ?>">Edit</a></li>
                                                <?php endif; ?>
                                                <?php if(userCanView('stock.toggle')): ?>
                                                    <li><a href="<?php echo e(route('stock.toggle',$batch->stock->id)); ?>"><?php echo e($batch->stock->status == 0 ? 'Enabled' : 'Disabled'); ?></a></li>
                                                <?php endif; ?>
                                                    <?php if(userCanView('stock.stock_report')): ?>
                                                        <li><a href="<?php echo e(route('stock.stock_report',$batch->stock->id)); ?>">Product Report</a></li>
                                                    <?php endif; ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <?php if(config('app.store') == "inventory"): ?>
                            <?php echo $batches->links(); ?>

                        <?php endif; ?>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/stock/list-available.blade.php ENDPATH**/ ?>