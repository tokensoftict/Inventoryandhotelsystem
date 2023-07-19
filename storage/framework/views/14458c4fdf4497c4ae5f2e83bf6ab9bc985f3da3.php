<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print Invoice #<?php echo e($invoice->id); ?></title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            font-size: 9pt;
            background-color: #fff;
        }

        #products {
            width: 90%;
        }
        #products th, #products td {
            padding-top:5px;
            padding-bottom:5px;
            border: 1px solid black;
        }
        #products tr td {
            font-size: 8pt;
        }

        #printbox {
            width: 98%;
            margin: 5pt;
            padding: 5px;
            margin: 0px auto;
            text-align: justify;
        }

        .inv_info tr td {
            padding-right: 10pt;
        }

        .product_row {
            margin: 15pt;
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
<div id="printbox">
    <table width="65%">
        <tr><td valign="top">
                <h2  class="text-center"><?php echo e($store->name); ?></h2>
                <p align="center">
                    <?php echo e($store->first_address); ?>

                    <?php if(!empty($store->second_address)): ?>
                        <br/>
                        <?php echo e($store->second_address); ?>

                    <?php endif; ?>
                    <?php if(!empty($store->contact_number)): ?>
                        <br/>
                        <?php echo e($store->contact_number); ?>

                    <?php endif; ?>
                </p>
            </td>
        </tr>
        <td valign="top" width="35%">
            <img style="max-height:100px;float: right;" src="<?php echo e(public_path("img/". $store->logo)); ?>" alt='Logo'>
        </td>
    </table>


    <table  class="inv_info">

        <tr>
            <td>Invoice / Receipt No</td>
            <td><?php echo e($invoice->invoice_paper_number); ?></td>
        </tr>
        <tr>
            <td>Invoice Number</td>
            <td><?php echo e($invoice->invoice_number); ?></td>
        </tr>
        <tr>
            <td>Invoice Date</td>
            <td><?php echo e(convert_date($invoice->invoice_date)); ?></td>
        </tr>
        <tr>
            <td>Time</td>
            <td><?php echo e(date("h:i a",strtotime($invoice->sales_time))); ?></td>
        </tr>
        <tr>
            <td>Customer</td>
            <td><?php echo e($invoice->customer->firstname); ?> <?php echo e($invoice->customer->lastname); ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?php echo e($invoice->status); ?></td>
        </tr>
    </table>


    <h2 style="margin-top:0" class="text-center">Sales Invoice / Receipt</h2>

    <table id="products">
        <tr class="product_row">
            <td>#</td>
            <td align="left"><b>Name</b></td>
            <td align="center"><b>Quantity</b></td>
            <td align="center"><b>Price</b></td>
            <td align="right"><b>Total</b></td>
        </tr>
        <tbody id="appender">
        <?php $__currentLoopData = $invoice->invoice_items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
            <td  align="right" class="text-right">Sub Total</td>
            <td  align="right" class="text-right"><?php echo e(number_format($invoice->sub_total,2)); ?></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td   align="right" class="text-right">Total</td>
            <td  align="right" class="text-right"><b><?php echo e(number_format(($invoice->sub_total -$invoice->discount_amount),2)); ?></b></td>
            <td></td>
        </tr>
        </tfoot>
    </table>

    <div class="text-center">  <?php echo e($store->footer_notes); ?></div>
    <br/>
    <div align="center">

    </div>
    <br/>
    <div class="text-center"> <?php echo softwareStampWithDate(); ?></div>
</div>
</body>
</html>

<?php /**PATH C:\xampp\htdocs\TokenSoft\Inventoryandhotelsystem\resources\views/print/pos_afour.blade.php ENDPATH**/ ?>