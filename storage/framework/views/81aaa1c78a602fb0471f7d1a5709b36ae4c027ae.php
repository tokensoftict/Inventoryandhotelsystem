<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo e($table->id); ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 10pt;
            background-color: #fff;
        }

        #products {
            width: 100%;
        }

        #products tr td {
            font-size: 10pt;
        }

        #printbox {
            width: 80mm;
            margin: 5pt;
            padding: 5px;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 14pt;
        }

        .product_row {
            margin: 13pt;
        }

        .stamp {
            margin: 5pt;
            padding: 3pt;
            border: 3pt solid #111;
            text-align: center;
            font-size: 20pt;
            color:#000;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
<h3 id="logo" class="text-center"><br><img style="max-height:30px;" src="<?php echo e(public_path("img/". $store->logo)); ?>" alt='Logo'></h3>
<div id="printbox">
    <h2 style="margin:-2px;padding: 0px" class="text-center"><?php echo e($store->name); ?></h2>
    <div align="center" >
        <?php echo e($store->first_address); ?>

        <?php if(!empty($store->second_address)): ?>
            <br/>
            <?php echo e($store->second_address); ?>

        <?php endif; ?>
        <?php if(!empty($store->contact_number)): ?>
            <br/>
            <?php echo e($store->contact_number); ?>

        <?php endif; ?>
    </div>
    <table class="inv_info">
        <tr>
            <td>Department</td>
            <td><?php echo e($table->department); ?></td>
        </tr>
        <tr>
            <td>Date</td>
            <td><?php echo e(convert_date2(now()->toDateString())); ?></td>
        </tr>
    </table>
    <hr>
    <h3 align="center"><?php echo e($table->name); ?></h3>
    <hr>
    <table id="products">
        <tr class="product_row">
            <td>#</td>
            <td align="left"><b>Name</b></td>
            <td align="center"><b>Quantity</b></td>
            <td align="center"><b>Price</b></td>
            <td align="right"><b>Total</b></td>
        </tr>
        <tr>
            <td colspan="5">
                <hr>
            </td>
        </tr>
        <tbody id="appender">
        <?php $__currentLoopData = $table->invoice_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($loop->iteration); ?></td>
                <td align="left" class="text-left"><?php echo e($item->stock->name); ?></td>
                <td align="center" class="text-center"><?php echo e($item->quantity); ?></td>
                <td align="center" class="text-center"><?php echo e(number_format($item->selling_price,2)); ?></td>
                <td align="right" class="text-right"><?php echo e(number_format(($item->total_selling_price),2)); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
        <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td class="text-right">Sub Total</td>
            <td class="text-right"><?php echo e(money($table->invoice_items->sum('total_selling_price'))); ?></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td  align="right" class="text-right">Total</td>
            <td  align="right" class="text-right"><b><?php echo e(money($table->invoice_items->sum('total_selling_price'))); ?></b></td>
        </tr>
        </tfoot>
    </table>
    <hr>
    <div class="text-center">  <?php echo e($store->footer_notes); ?></div>
    <div class="text-center"> <?php echo softwareStampWithDate(); ?></div>
</div>
</body>
</html><?php /**PATH /Users/yusufolatunji/MyProject/Web/Inventoryandhotelsystem/resources/views/print/postable.blade.php ENDPATH**/ ?>