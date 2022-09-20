<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-md-7 col-lg-offset-3">
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
                        <?php if(!isset($room->id)): ?>
                        <form  method="POST" action="<?php echo e(route('room.store')); ?>">
                         <?php else: ?>
                             <form  method="POST" action="<?php echo e(route('room.update',$room->id)); ?>">
                                <?php echo e(method_field('PUT')); ?>

                        <?php endif; ?>
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                            <label for="type_id" class="form-label">Room Type</label>
                            <select id="type_id" name="room_type_id" class="form-control select2">
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option <?php echo e($room->type_id == $type->id ? "selected" : ""); ?> value="<?php echo e($type->id); ?>"><?php echo e($type->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['type_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="text-danger mt-1">
                                <?php echo e($message); ?>

                            </div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="form-group">
                                <label for="number" class="form-label">Room Name</label>
                                <input type="text" class="form-control" id="number" name="name" value="<?php echo e(old('name',$room->name)); ?>" placeholder="Room Name ex : Room 101">
                            </div>
                            <div class="form-group" >
                                <label for="capacity" class="form-label">Room Capacity</label>
                                <input text="text" class="form-control" id="capacity" name="capacity" value="<?php echo e(old('capacity', $room->capacity)); ?>" placeholder="Room Capacity">
                            </div>
                            <div class="form-group" >
                                <label for="price" class="form-label">Room Rate (Price)</label>
                                <input type="text" class="form-control" id="price" name="price" value="<?php echo e(old('price', $room->price)); ?>" placeholder="Room Rate">
                            </div>
                            <div class="form-group" >
                                <label for="view" class="form-label">Description</label>
                                <textarea class="form-control" id="view" name="view" rows="3" placeholder="Description"><?php echo e(old('view', $room->view)); ?></textarea>
                            </div>
                                <button room="submit" class="btn btn-lg btn-primary">Save</button>
                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/receptionist/rooms/form.blade.php ENDPATH**/ ?>