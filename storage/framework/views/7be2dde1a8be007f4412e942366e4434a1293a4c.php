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
                            <p>نرجو منك التكرم بتحويل مبلغ الطلب على حسابنا التالي : </p>
                            <p>مصرف الإنماء :</p>
                            <p>68201698498000</p>
                            <p>الآيبان : (مصرف الإنماء)</p>
                            <p>SA2405000068201698498000</p>
                            <p>مصرف الراجحي :</p>
                            <p>454000010006086033087</p>
                            <p>الآيبان : (مصرف الراجحي)</p>
                            <p>SA5880000454608016033087</p>
                            <p>(مؤسسة ورود فريدة للتجارة)</p>
                            <br/>
                            <p>بعد تحويل المبلغ، يرجى تعبئة نموذج التحويل من خلال الرابط أدناه :</p>
                            <?php $__env->startComponent('mail::button', ['url' => $url, 'color' => 'primary']); ?>
                            نموذج تأكيد الإيداع
                            <?php echo $__env->renderComponent(); ?>
                        </div>
                        <p><?php echo app('translator')->getFromJson('Thank you for ordering from'); ?> <?php echo app('translator')->getFromJson('Faridah Flowers'); ?>.</p>
                    </td>
                </tr>
            </table>
        </center>
    </td>
</tr>
<?php echo $__env->renderComponent(); ?>