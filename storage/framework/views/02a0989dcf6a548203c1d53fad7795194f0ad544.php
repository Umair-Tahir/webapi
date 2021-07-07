<style>

    @import  url(https://fonts.googleapis.com/css?family=Roboto:100,300,400,900,700,500,300,100);
    #invoiceholder *{
        margin: 0;
        box-sizing: border-box;

    }
    ::selection {background: #f31544; color: #FFF;}
    ::moz-selection {background: #f31544; color: #FFF;}
    h1{
        font-size: 1.5em;
        color: #222;
    }
    h2{font-size: .9em;}
    h3{
        font-size: 1.2em;
        font-weight: 300;
        line-height: 2em;
    }
    #invoiceholder p{
        font-size: .7em;
        color: #666;
        line-height: 1.2em;
    }

    #invoiceholder{
        width:100%;
        height: 100%;
        padding-top: 50px;
    }
    #invoice{
        position: relative;
        top: -50px;
        margin: 0 auto;
        width: 700px;
        background: #FFF;
    }

    [id*='invoice-']{ /* Targets all id with 'col-' */
        border-bottom: 1px solid #EEE;
        padding: 30px;
    }

    #invoice-top{min-height: 120px;}
    #invoice-mid{min-height: 120px;}
    #invoice-bot{ min-height: 250px;}

    .info{
        display: block;
        float:left;
        margin-left: 20px;
    }
    .title{
        float: right;
    }
    .title p{text-align: right;}
    #project{float: right}
    p#deliverDuration{
        float: right;
        font-size: 15px !important;
    }
    table{
        width: 100%;
        border-collapse: collapse;
    }
    td.tableitem{
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE
    }
    td.item {
        padding: 5px 0 5px 15px;
        border: 1px solid #EEE;
    }
    .tabletitle{
        padding: 5px;
        background: #EEE;
    }
    .service{border: 1px solid #EEE;}
    .item{width: 50%;}
    .itemtext{font-size: .9em;}

    #legalcopy{
        margin-top: 30px;
    }
    form{
        float:right;
        margin-top: 30px;
        text-align: right;
    }
    strong#deliveryTime {
        color: black;
        font-size: 12px;
    }

    .legal{
        width:100%;
    }
</style>
<div style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;color:#74787e;height:100%;line-height:1.4;margin:0;width:100%!important;word-break:break-word">

    <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#f5f8fa;margin:0;padding:0;width:100%"><tbody><tr>
            <td align="center" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box">
                <table width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;margin:0;padding:0;width:100%">
                    <tbody><tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:25px 0;text-align:center;background-color: #ffc107 !important">
                            <a href="https://www.eezly.com" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#bbbfc3;font-size:19px;font-weight:bold;text-decoration:none" target="_blank" data-saferedirecturl="https://www.google.com/url?q=https://www.eezly.com&amp;source=gmail&amp;ust=1608897117682000&amp;usg=AFQjCNGQHshUo80mqTF_EDsvyRdOmFiYaw">
                                <image  src="https://ally.eezly.com/images/logo_default.png" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td width="100%" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;border-bottom:1px solid #edeff2;border-top:1px solid #edeff2;margin:0;padding:0;width:100%">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;background-color:#ffffff;margin:0 auto;padding:0;width:570px">
                                <tbody><tr>
                                    <td style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;padding:35px">
                                        <h1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#2f3133;font-size:19px;font-weight:bold;margin-top:0;text-align:left">Hello!</h1>
                                        <p style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><?php if($toRestaurant): ?> You've received a new order. Please watch the details mentioned below. <?php else: ?> Your order has been received and will be ready to deliver shortly. Please check the following Invoice related to your order. <?php endif; ?></p>
                                        <div id="invoiceholder">

                                            <div id="invoice" class="effect2">

                                                <div id="invoice-top">
                                                    <div class="info">
                                                        <h2><?php if(isset($order->user->name)): ?> <?php echo e($order->user->name); ?>  <?php endif; ?></h2>
                                                        <p> <?php if(isset($order->user->phone_number)): ?> <?php echo e($order->user->phone_number); ?>  <?php endif; ?> </br>
                                                            <?php echo isset($order->deliveryAddress) ? $order->deliveryAddress->address : ''; ?>



                                                        </p>
                                                    </div><!--End Info-->
                                                    <div class="title">
                                                        <h1>Order #<?php if(isset($order)): ?><?php echo e($order->id); ?> <?php else: ?> Null <?php endif; ?></h1>
                                                        <p>Status: <?php if(isset($order)): ?><?php echo e($order->orderStatus->status); ?> <?php else: ?> Null <?php endif; ?></br>
                                                            Date: <?php if(isset($order)): ?><?php echo e($order->orderStatus->created_at->toDateString()); ?>  <?php endif; ?>
                                                        </p>
                                                    </div><!--End Title-->
                                                </div><!--End InvoiceTop-->


                                                <div id="invoice-mid">
                                                    <div class="info">
                                                        <h2><?php if(isset($order->restaurant->name)): ?><?php echo e($order->restaurant->name); ?>  <?php endif; ?></h2>
                                                        <p> <?php if(isset($order->restaurant->phone)): ?><?php echo e($order->restaurant->phone); ?> <?php endif; ?></br>
                                                            <?php if(isset($order->restaurant->address)): ?>  <?php echo e($order->restaurant->address); ?> <?php endif; ?>
                                                        </p>
                                                    </div>

                                                    <div id="project">
                                                        <h2>Expected Delivery time</h2>
                                                        <p id="deliverDuration"><?php if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time)): ?>  <?php echo e($order->expected_delivery_time); ?> min  <?php endif; ?> </p>
                                                    </div>
                                                </div><!--End Invoice Mid-->

                                                <div id="invoice-bot">

                                                    <div id="table">
                                                        <table>
                                                            <tr class="tabletitle">
                                                                <td class="item"><h2>Item</h2></td>
                                                                <td class="Hours"><h2>Quantity</h2></td>
                                                                <td class="Rate"><h2>Price</h2></td>
                                                                <td class="subtotal"><h2>Sub-total</h2></td>
                                                            </tr>
                                                            <?php if(isset($order)): ?>
                                                                <?php $__currentLoopData = $order->foodOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $foodOrder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <tr class="service">
                                                                        <td class="tableitem"><p class="itemtext"><?php echo e($foodOrder->food->first()->name); ?></p></td>
                                                                        <td class="tableitem"><p class="itemtext"><?php echo e($foodOrder->quantity); ?></p></td>
                                                                        <td class="tableitem"><p class="itemtext">$<?php echo e($foodOrder->food->first()->price); ?></p></td>
                                                                        <td class="tableitem"><p class="itemtext">$<?php echo e($foodOrder->price); ?></p></td>
                                                                    </tr>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            <?php endif; ?>

                                                            <?php if(isset($order->delivery_fee) && $order->delivery_fee!=0): ?>
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Delivery Fee</p></td>
                                                                    <td class="tableitem"><p class="itemtext" >$<?php echo e($order->delivery_fee); ?></p></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <?php if($toRestaurant): ?>
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Restaurant Shared Price</p></td>
                                                                    <td class="tableitem"><p class="itemtext">$<?php echo e($order->vendor_shared_price); ?></p></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <?php if($toRestaurant): ?>
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">eezly Fee</p></td>
                                                                    <td class="tableitem"><p class="itemtext">$<?php echo e($order->eezly_shared_price); ?></p></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <?php if(isset($order->tip)): ?>
                                                                <tr class="service">
                                                                    <td class="tableitem"><p class="itemtext"></p></td>
                                                                    <td class="tableitem" colspan="2"><p class="itemtext">Tip</p></td>
                                                                    <td class="tableitem"><p class="itemtext">$<?php echo e($order->tip); ?></p></td>
                                                                </tr>
                                                            <?php endif; ?>
                                                            <tr class="service">
                                                                <td class="tableitem"><p class="itemtext"></p></td>
                                                                <td class="tableitem" colspan="2"><p class="itemtext">Tax(14.975%)</p></td>
                                                                <td class="tableitem"><p class="itemtext"> <?php if(isset($order)): ?> $<?php echo e($order->tax); ?>  <?php endif; ?></p></td>
                                                            </tr>


                                                            <tr class="tabletitle">
                                                                <td></td>
                                                                <td></td>
                                                                <td class="Rate"><h2>Total</h2></td>
                                                                <td class="payment"><h2> <?php if(isset($order)): ?> $<?php echo e($order->grand_total); ?>  <?php endif; ?></h2></td>
                                                            </tr>

                                                        </table>
                                                    </div><!--End Table-->


                                                    <div id="legalcopy">
                                                        <?php if($toRestaurant): ?>
                                                                 <?php if($order->delivery_type_id=1): ?>
                                                                <p class="legal"><strong>Thank you for using eezly!</strong>  The order is expected to be picked up within <strong id="deliveryTime"><?php if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time)): ?>  <?php echo e($order->expected_delivery_time); ?> min  <?php endif; ?></strong>.Please reach out to customer via provided phone number if any delay is expected in delivery.</p>

                                                            <?php else: ?>
                                                                <p class="legal"><strong>Thank you for using eezly!</strong>  The order is expected to be delivered within <strong id="deliveryTime"><?php if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time)): ?>  <?php echo e($order->expected_delivery_time); ?> min  <?php endif; ?></strong>.Please reach out to customer via provided phone number if any delay is expected in delivery.</p>
                                                            <?php endif; ?>
                                                        <?php else: ?>
                                                            <?php if($order->delivery_type_id=1): ?>
                                                                <p class="legal"><strong>Thank you for using eezly!</strong>  Your order will be ready for pick up within <strong id="deliveryTime"><?php if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time)): ?>  <?php echo e($order->expected_delivery_time); ?> min  <?php endif; ?></strong>.Please contact us if you have any questions regarding the order.</p>
                                                            <?php else: ?>
                                                                <p class="legal"><strong>Thank you for using eezly!</strong>  Your order will be delivered within <strong id="deliveryTime"><?php if(isset($order->expected_delivery_time) && !is_null($order->expected_delivery_time)): ?>  <?php echo e($order->expected_delivery_time); ?> min  <?php endif; ?></strong>.Please contact us if you have any questions regarding the order.</p>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </div>

                                                </div><!--End InvoiceBot-->
                                            </div><!--End Invoice-->
                                        </div><!-- End Invoice Holder-->
                                        <H3 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;color:#74787e;font-size:16px;line-height:1.5em;margin-top:0;text-align:left">Feel free to reach out for any concerns and queries by email at <a  href="mailto:hello@eezly.com">hello@eezly.com</a> or by phone at 1-888-693-3959.</H3>
                                        <H1 style="font-family:Avenir,Helvetica,sans-serif;box-sizing:border-box;font-size:16px;line-height:1.5em;margin-top:0;text-align:left"><span style="color:#74787e;font-size: 14px;">Regards,</span><br>eezly</H1>
                                    </td>
                                </tr>
                                </tbody></table>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-family:Avenir,Helvetica,sans-serif;background-color: #ffc107 !important">
                            <table align="center" width="570" cellpadding="0" cellspacing="0" style="font-family:Avenir,Helvetica,sans-serif;margin:0 auto;padding:0;text-align:center;width:570px"><tbody><tr>
                                    <td align="center" style="font-family:Avenir,Helvetica,sans-serif;padding:35px">
                                        <p style="font-family:Avenir,Helvetica,sans-serif;line-height:1.5em;margin-top:0;color:#000000 !important;font-size:12px;text-align:center">© 2021 eezly. All rights reserved.</p>
                                    </td>
                                </tr></tbody></table>
                        </td>
                    </tr>
                    </tbody></table>
            </td>
        </tr></tbody></table><div class="yj6qo"></div><div class="adL">
    </div></div>
<?php /**PATH C:\xampp\htdocs\eezlyapi\resources\views/emails/emailInvoiceEN.blade.php ENDPATH**/ ?>