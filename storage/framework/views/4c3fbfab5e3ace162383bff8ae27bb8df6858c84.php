<?php $__env->startComponent('mail::message'); ?>
<tr>
    <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
        <center>
            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                <tr>
                    <td>
                        <br/>
                        <h2><?php echo app('translator')->getFromJson('Hi'); ?> <?php echo e($order->username); ?></h2>
                        <h3><?php echo app('translator')->getFromJson('Thank you for ordering from'); ?> <?php echo app('translator')->getFromJson('Faridah Flowers'); ?>.</h3>
                        <div>
                            <p><b><?php echo app('translator')->getFromJson('Order ID'); ?> : </b>#<?php echo e($order->id); ?></p>
                            <p><b><?php echo app('translator')->getFromJson('Order Status'); ?> : </b><?php echo e($order->currentStatus->theName); ?></p>
                            <br/>
                            <p><?php echo app('translator')->getFromJson('We apologize, there is an error in your attempt to complete the payment, please go to the Orders page and try your payment again. You do not need to re-order again'); ?> .</p>
                            <br/>
                        </div>
                        <p><?php echo app('translator')->getFromJson('Thank you for ordering from'); ?> <?php echo app('translator')->getFromJson('Faridah Flowers'); ?>.</p>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
<?php echo $__env->renderComponent(); ?>