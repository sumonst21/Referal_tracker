<?php $__currentLoopData = $lineitems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lineitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <!--description-->
    <td class="x-description text-wrap-new-lines"><?php echo e($lineitem->lineitem_description); ?></td>
    <!--quantity-->
    <?php if($lineitem->lineitem_type == 'plain'): ?>
    <td class="x-quantity"><?php echo e($lineitem->lineitem_quantity); ?></td>
    <?php else: ?>
    <td class="x-quantity">
        <?php if($lineitem->lineitem_time_hours > 0): ?>
        <?php echo e($lineitem->lineitem_time_hours); ?><?php echo e(strtolower(__('lang.hrs'))); ?>&nbsp;
        <?php endif; ?>
        <?php if($lineitem->lineitem_time_minutes > 0): ?>
        <?php echo e($lineitem->lineitem_time_minutes); ?><?php echo e(strtolower(__('lang.mins'))); ?> 
        <?php endif; ?>
    </td>
    <?php endif; ?>
    <!--unit price-->
    <td class="x-unit"><?php echo e($lineitem->lineitem_unit); ?></td>
    <!--rate-->
    <td class="x-rate"><?php echo e(runtimeNumberFormat($lineitem->lineitem_rate)); ?></td>
    <!--tax-->
    <td class="x-tax <?php echo e(runtimeVisibility('invoice-column-inline-tax', $bill->bill_tax_type)); ?>"></td>
    <!--total-->
    <td class="x-total text-right"><?php echo e(runtimeNumberFormat($lineitem->lineitem_total)); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/application/resources/views/pages/bill/components/elements/lineitems.blade.php ENDPATH**/ ?>