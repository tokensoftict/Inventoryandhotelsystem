<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-md-8">
                <section class="panel">
                    <header class="panel-heading">
                        <?php echo e($title); ?>

                    </header>
                    <div class="panel-body">
                        <?php if(session('success')): ?>
                            <?php echo alert_success(session('success')); ?>

                        <?php elseif(session('error')): ?>
                            <?php echo alert_error(session('error')); ?>

                        <?php endif; ?>

                        <table class="table table-hover table-hover">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            <?php $__currentLoopData = $room_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($loop->iteration); ?></td>
                                    <td><?php echo e($room_type->name); ?></td>
                                    <td><?php echo $room_type->status == 1 ? label("Active","success") : label("Inactive","danger"); ?></td>
                                    <td>
                                        <?php if(userCanView('room_type.toggle')): ?>
                                            <?php if($room_type->status == 1): ?>
                                                <a href="<?php echo e(route('room_type.toggle',$room_type->id)); ?>" class="btn btn-danger btn-sm">Disable</a>
                                            <?php else: ?>
                                                <a href="<?php echo e(route('room_type.toggle',$room_type->id)); ?>" class="btn btn-success btn-sm">Enable</a>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if(userCanView('room_type.edit')): ?>
                                            <a href="<?php echo e(route('room_type.edit',$room_type->id)); ?>" class="btn btn-success btn-sm">Edit</a>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>

                    </div>
                </section>
            </div>
            <?php if(userCanView('room_type.create')): ?>
                <div class="col-md-4">
                    <section class="panel">
                        <header class="panel-heading">
                            <?php echo e($title2); ?>

                        </header>
                        <div class="panel-body">
                            <form id="validate" action="<?php echo e(route('room_type.store')); ?>" enctype="multipart/form-data" method="post">
                                <?php echo e(csrf_field()); ?>

                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" value="<?php echo e(old('name')); ?>" required  class="form-control" name="name" placeholder="Name"/>
                                    <?php if($errors->has('name')): ?>
                                        <label for="name-error" class="error"
                                               style="display: inline-block;"><?php echo e($errors->first('name')); ?></label>
                                    <?php endif; ?>
                                </div>
                                <div class="pull-left">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                                <br/> <br/>
                            </form>
                        </div>
                    </section>
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/settings/room_types/list-types.blade.php ENDPATH**/ ?>