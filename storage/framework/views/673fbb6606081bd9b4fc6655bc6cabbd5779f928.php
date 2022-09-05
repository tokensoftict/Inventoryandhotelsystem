<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-sm-5">
                <?php if(session('success')): ?>
                    <?php echo alert_success(session('success')); ?>

                <?php elseif(session('error')): ?>
                    <?php echo alert_error(session('error')); ?>

                <?php endif; ?>
                <section class="panel">
                    <header class="panel-heading">
                        Import New Stock
                    </header>
                    <div class="panel-body">
                        <form action="<?php echo e(route('stock.import_new_stock')); ?>" method="post" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                <label>Select Excel File</label>
                                <input type="file" class="form-control" name="excel_file"/>
                            </div>
                            <button type="submit" class="btn btn-default">Upload</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/stock/import_new_stock.blade.php ENDPATH**/ ?>