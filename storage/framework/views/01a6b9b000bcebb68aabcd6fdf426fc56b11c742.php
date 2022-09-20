<?php $__env->startPush('css'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/select2/dist/css/select2.min.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css')); ?>">
 <?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-md-7 col-md-offset-3">
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
                        <?php if(isset($booking->id)): ?>
                                <form action="<?php echo e(route('bookings_and_reservation.update',$booking->id)); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo e(method_field('PUT')); ?>

                       <?php else: ?>
                        <form action="<?php echo e(route('bookings_and_reservation.store')); ?>" method="post" enctype="multipart/form-data">
                        <?php endif; ?>
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group">
                                <label>Select Available Rooms</label>
                                <select required multiple class="form-control select-room" name="room_id[]">
                                    <option value="">Select Room</option>
                                    <?php $__currentLoopData = $rooms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $room): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e(in_array( $room->id, $selected_rooms) ? 'selected' : ''); ?>  value="<?php echo e($room->id); ?>"><?php echo e($room->room_type->name); ?> - <?php echo e($room->name); ?> - <?php echo e(number_format($room->price,2)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($errors->has('bank_id')): ?>
                                        <label for="name-error" class="error"
                                               style="display: inline-block;"><?php echo e($errors->first('bank_id')); ?></label>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="form-group" >
                                <label for="booking_date" class="form-label">Booking Date</label>
                                <input text="text"  data-min-view="2" data-date-format="yyyy-mm-dd" class="form-control datepicker js-datepicker"  id="booking_date" name="booking_date" value="<?php echo e(old('booking_date', (isset($booking->booking_date) ?  date('Y-m-d',strtotime($booking->booking_date)) : date('Y-m-d')))); ?>" placeholder="Starting Date">
                            </div>

                            <div class="form-group" >
                                <label for="start_date" class="form-label">From</label>
                                <input text="text"  data-min-view="2" data-date-format="yyyy-mm-dd" class="form-control datepicker js-datepicker"  id="from" name="start_date" value="<?php echo e(old('start_date', (isset($booking->start_date) ? date('Y-m-d',strtotime($booking->start_date)) : date('Y-m-d')))); ?>" placeholder="Starting Date">
                            </div>
                            <div class="form-group" >
                                <label for="end_date" class="form-label">To</label>
                                <input text="text"   data-min-view="2" data-date-format="yyyy-mm-dd" class="form-control datepicker js-datepicker"  id="end_date" name="end_date" value="<?php echo e(old('end_date', (isset($booking->end_date) ? date('Y-m-d',strtotime($booking->end_date)) : date('Y-m-d',strtotime("+ 1 days"))))); ?>" placeholder="End Date">
                            </div>

                            <h4>Customer Information</h4>
                            <div class="form-group">
                                <label>Select Customer</label>
                                <select class="form-control select-customer" name="customer_id">
                                    <option value="" selected>Select Customer</option>
                                    <option value="_NEW">New Customer</option>
                                    <?php $__currentLoopData = $customers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php echo e($cus->id == $booking->customer_id ? "selected" : ""); ?> value="<?php echo e($cus->id); ?>"><?php echo e($cus->firstname); ?> <?php echo e($cus->lastname); ?> - <?php echo e($cus->phone_number); ?></option>
                                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div id="customer_information" class="row" style="display: none">
                                <div class="col-sm-12">
                                <h4>Customer Information</h4>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>First Name</label>
                                    <input type="text" value="<?php echo e(old('firstname',$customer->firstname)); ?>"   class="form-control" name="firstname" placeholder="First Name"/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Last Name</label>
                                    <input type="text" value="<?php echo e(old('lastname',$customer->lastname)); ?>"   class="form-control" name="lastname" placeholder="Last Name"/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Email</label>
                                    <input type="text" value="<?php echo e(old('email',$customer->email)); ?>"   class="form-control" name="email" placeholder="Email Address"/>
                                </div>

                                <div class="form-group  col-sm-6" >
                                    <label>Phone Number</label>
                                    <input type="text" value="<?php echo e(old('phone_number',$customer->phone_number)); ?>"   class="form-control" name="phone_number" placeholder="Phone Number"/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Passport Number</label>
                                    <input type="text" value="<?php echo e(old('passport_no',$customer->passport_no)); ?>"   class="form-control" name="passport_no" placeholder="Passport No."/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Passport Expiring Date</label>
                                    <input type="text" data-min-view="2" data-date-format="yyyy-mm-dd" class="form-control datepicker js-datepicker"  value="<?php echo e(old('passport_expire_date',$customer->passport_expire_date)); ?>"  name="passport_expire_date" placeholder="Passport Expiring Date"/>
                                </div>


                                <div class="form-group  col-sm-4" >
                                    <label>Purpose Of Visit</label>
                                    <input type="text" value="<?php echo e(old('purpose_of_visit',$customer->purpose_of_visit)); ?>"   class="form-control" name="purpose_of_visit" placeholder="Purpose Of Visit"/>
                                </div>
                                <div class="form-group  col-sm-4" >
                                    <label>Vehicle Reg. Number</label>
                                    <input type="text" value="<?php echo e(old('vehicle_reg_number',$customer->vehicle_reg_number)); ?>"   class="form-control" name="vehicle_reg_number" placeholder="Vehicle Reg. Number"/>
                                </div>
                                <div class="form-group  col-sm-4" >
                                    <label>Arriving From</label>
                                    <input type="text" value="<?php echo e(old('arriving_from',$customer->arriving_from)); ?>"   class="form-control" name="arriving_from" placeholder="Arriving From"/>
                                </div>


                                <div class="form-group  col-sm-4" >
                                    <label>Nationality</label>
                                    <input type="text" value="<?php echo e(old('nationality',$customer->nationality)); ?>"   class="form-control" name="nationality" placeholder="Nationality"/>
                                </div>
                                <div class="form-group  col-sm-4" >
                                    <label>State</label>
                                    <input type="text" value="<?php echo e(old('state',$customer->state)); ?>"   class="form-control" name="state" placeholder="State"/>
                                </div>
                                <div class="form-group  col-sm-4" >
                                    <label>City</label>
                                    <input type="text" value="<?php echo e(old('city',$customer->city)); ?>"   class="form-control" name="city" placeholder="City"/>
                                </div>


                                <div class="form-group  col-sm-4" >
                                    <label>Occupation</label>
                                    <input type="text" value="<?php echo e(old('occupation',$customer->occupation)); ?>"   class="form-control" name="occupation" placeholder="Occupation"/>
                                </div>
                                <div class="form-group  col-sm-8" >
                                    <label>Address</label>
                                    <textarea class="form-control" name="address"><?php echo e(old('address',$customer->address)); ?></textarea>
                                </div>

                                <div class="col-sm-12">
                                    <h4>Next Of Kin Information</h4>
                                </div>

                                <div class="form-group col-sm-6">
                                    <label>First Name</label>
                                    <input type="text" value="<?php echo e(old('nok_firstname',$customer->nok_firstname)); ?>"   class="form-control" name="nok_firstname" placeholder="Next of Kin First Name"/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Last Name</label>
                                    <input type="text" value="<?php echo e(old('nok_lastname',$customer->nok_lastname)); ?>"   class="form-control" name="nok_lastname" placeholder="Next of Kin Last Name"/>
                                </div>
                                <div class="form-group  col-sm-6" >
                                    <label>Email</label>
                                    <input type="text" value="<?php echo e(old('nok_email',$customer->nok_email)); ?>"   class="form-control" name="nok_email" placeholder="Next of Kin Email Address"/>
                                </div>

                                <div class="form-group  col-sm-6" >
                                    <label>Phone Number</label>
                                    <input type="text" value="<?php echo e(old('nok_phone_number',$customer->nok_phone_number)); ?>"   class="form-control" name="nok_phone_number" placeholder="Next of Kin Phone Number"/>
                                </div>

                            </div>
                            <div class="form-group" style="display: none">
                                <h4>Customer Identity (Optional)</h4>
                                <label>Upload Customer Identity</label>
                                <input type="file"   class="form-control" name="identity"/>
                            </div>

                            <button type="submit" class="btn btn-primary text-center"><i class="fa fa-save"></i> Book / Reserve Room</button>

                        </form>

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
    <script  src="<?php echo e(asset('assets/js/init-datepicker.js')); ?>"></script>

    <script>

        $(document).ready(function(e){
            $('.select-customer').on('change',function(e){
                if($(this).val() == "_NEW"){
                    $('#customer_information').removeAttr('style').find('.form-control').attr('required','required');
                }else{
                    $('#customer_information').attr('style','display:none').find('.form-control').removeAttr('required');
                }
            })
        })

    </script>

 <?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotel/resources/views/receptionist/bookings/new-reservation.blade.php ENDPATH**/ ?>