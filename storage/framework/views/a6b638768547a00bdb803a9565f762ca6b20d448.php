<?php $__env->startSection('content'); ?>
    <div class="ui-container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
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
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group">
                                <label for="exampleInputEmail1">Department</label>
                                <span class="form-control"><?php echo e($table->department); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Name</label>
                                <span class="form-control"><?php echo e($table->name); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Total Table Amount</label>
                                <span class="form-control"><?php echo e(money($total_amount)); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Today's Date</label>
                                <span class="form-control"><?php echo e(str_date(now()->toDateString())); ?></span>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Payment Method</label>
                                <select class="form-control" name="payment_method_id" id="payment_method">
                                    <option value="">Select Payment Method</option>
                                    <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(strtolower( $payment->name) == "credit"): ?>
                                            <?php continue; ?>
                                         <?php endif; ?>
                                        <option  data-label="<?php echo e(strtolower( $payment->name)); ?>"  value="<?php echo e($payment->id); ?>"><?php echo e($payment->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <!--<option  data-label="split_method"  value="split_method">MULTIPLE PAYMENT METHOD</option>-->
                                </select>
                            </div>
                            <div id="more_info_appender">
                            </div>

                            <button type="submit" class="btn btn-primary text-center"><i class="fa fa-save"></i> Pay & Complete</button>

                        </form>
                    </div>
                </section>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>


<?php $__env->startPush('js'); ?>
    <script>

        function getPaymentInfo(){
            if($('#payment_method').val() === ""){
                alert("Please enter payment Information to complete invoice");
                return false;
            }

            if($('#payment_method').val() == "1"){
                if($('#cash_tendered').val() == ""){
                    alert("Please enter cash tendered by customer");
                    return false;
                }
                return {
                    'cash_tendered':$('#cash_tendered').val(),
                    'customer_change':$('#customer_change').html(),
                    'payment_method_id' : 1
                };
            }else if($('#payment_method').val() == "2"){
                if( $('#bank').val() === ""){
                    alert("Please select bank");
                    return false;
                }
                return {
                    'payment_method_id' : 2,
                    'bank_id' : $('#bank').val(),
                }

            }else if($('#payment_method').val() == "3"){
                if( $('#bank').val() === ""){
                    alert("Please select bank");
                    return false;
                }
                return {
                    'payment_method_id' : 3,
                    'bank_id' : $('#bank').val(),
                }

            }


            return false;
        }

        $(document).ready(function(){
            $("#payment_method").on("change",function () {
                if($(this).val() !=="") {
                    var selected = $("#payment_method option:selected").attr("data-label");
                    selected = selected.toLowerCase();
                    if (selected === "transfer") {
                        $("#payment_btn").removeAttr("disabled");
                        $("#more_info_appender").html('<div id="transfer"><div class="form-group"> <label>Bank</label> <select class="form-control" required id="bank" name="payment_info[bank]"><option value="">-Select Bank-</option> <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($bank->id); ?>"><?php echo e($bank->account_number); ?> - <?php echo e($bank->bank->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></div></div>')
                    } else if (selected === "cash") {
                        $("#payment_btn").removeAttr("disabled");
                        $("#more_info_appender").html('<div id="cash"> <br/><div class="form-group"> <label>Cash Tendered</label> <input class="form-control" type="number" step="0.00001" id="cash_tendered" name="payment_info[cash_tendered]" required placeholder="Cash Tendered"/></div><div class="form-group well"><center>Customer Change</center><h1 align="center" style="font-size: 55px; margin: 0; padding: 0 font-weight: bold;" id="customer_change">0.00</h1></div></div>')
                        handle_cash();
                    } else if (selected === "pos") {
                        $("#payment_btn").removeAttr("disabled");
                        $("#more_info_appender").html('<div class="form-group"> <label>Bank</label> <select class="form-control" required id="bank" name="payment_info[bank]"><option value="">-Select POS Bank-</option> <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($bank->id); ?>"><?php echo e($bank->account_number); ?> - <?php echo e($bank->bank->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select></div>')
                    } else if (selected === "split_method") {
                        $("#more_info_appender").html('<div id="split_method"> <br/><h5>MULTIPLE PAYMENT METHOD</h5><table class="table table-striped"> <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pmthod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($pmthod->id==4): ?> <?php continue; ?> <?php endif; ?><tr><td style="font-size: 15px;"><?php echo e(ucwords($pmthod->name)); ?></td><td class="text-right" align="right"><input value="0" step="0.00001" required class="form-control pull-right split_control" style="width: 100px;" type="number" data-key="<?php echo e($pmthod->id); ?>" name="split_method[<?php echo e($pmthod->id); ?>]"</td><td><?php if($pmthod->id != 4 && $pmthod->id!=1): ?><select class="form-control" name="payment_info_data[<?php echo e($pmthod->id); ?>]" id="bank_id_<?php echo e($pmthod->id); ?>"><option value="">Select Bank</option> <?php $__currentLoopData = $banks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bank): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($bank->id); ?>"><?php echo e($bank->account_number); ?> - <?php echo e($bank->bank->name); ?></option> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </select><?php endif; ?> <?php if($pmthod->id==1): ?> <input type="hidden" value="CASH" name="payment_info_data[<?php echo e($pmthod->id); ?>]"/> <?php endif; ?></td></tr> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><tr><th style="font-size: 15px;" colspan="2">Total</th><th class="text-right" id="total_split" style="font-size: 26px;">0.00</th></tr></table></div>')
                        handle_split_method();
                    }else{
                        $("#payment_btn").removeAttr("disabled");
                        $("#more_info_appender").html('')
                    }
                }else{
                    $("#payment_btn").removeAttr("disabled");
                    $("#more_info_appender").html("");
                }
            });

            function handle_cash(){
                $("#cash_tendered").on("keyup",function(){
                    if($(this).val() !="") {
                        var val = parseFloat($(this).val());
                        if (val > 0) {
                            var change = val - parseInt($('#total_amount_paid').val());
                            $("#customer_change").html(formatMoney(change));
                        }
                    }else{
                        $("#customer_change").html("<?php echo e(number_format(0,2)); ?>");
                    }
                })
            }

            function handle_split_method(){
                $('.split_control').on("keyup",function(){
                    var total = 0;
                    $('.split_control').each(function(index,elem){
                        if($(elem).val() !="") {
                            total += parseFloat($(elem).val());
                        }
                    });
                    $("#total_split").html(formatMoney(total));
                    if(total == <?php echo e($total_amount); ?> ){
                        $("#payment_btn").removeAttr("disabled");
                    }else{
                        $("#payment_btn").removeAttr("disabled");
                    }
                })

            }


        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/yusufolatunji/MyProject/Web/Inventoryandhotelsystem/resources/views/invoice/table_invoice_payment.blade.php ENDPATH**/ ?>