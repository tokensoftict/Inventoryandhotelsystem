

<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-sm-12">
                <form id="validate" action="<?php echo e(route('user.group.store')); ?>" method="post" class='form-horizontal'>
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo e($title); ?>

                        </header>
                        <div class="panel-body">
                            <div class="col-md-12">

                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label class="col-md-3 col-xs-12 control-label">User Group Name<span class="star">*</span>:</label>

                                    <div class="col-md-4 col-xs-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="fa fa-pencil"></span></span>
                                            <input type="text" name="name" value=""
                                                   class="validate[required] form-control" id="name">
                                        </div>
                                        <?php if($errors->has('name')): ?>
                                            <label for="name-error" class="error"
                                                   style="display: inline-block;"><?php echo e($errors->first('name')); ?></label>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <footer class="panel-footer">
                            <a href='<?php echo e(route('user.group.index')); ?>'>
                                <button class="btn btn-primary" data-toggle="tooltip" data-placement="top"><i
                                            class="fa fa-list"></i>View all User Groups
                                </button>
                            </a>
                            <button type="submit" class="btn btn-info pull-right"><span class="fa fa-edit"></span> Add
                                User Group
                            </button>
                        </footer>
                    </section>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\TokenSoft\Inventoryandhotelsystem\resources\views/access-control/add-user-group.blade.php ENDPATH**/ ?>