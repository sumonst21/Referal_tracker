<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="form-group row m-b-8">
    <label
        class="col-sm-12 text-left control-label col-form-label font-13 p-b-1 <?php echo e(runtimeCustomFieldsRequiredCSS($field->customfields_required)); ?>">
        <?php echo e($field->customfields_title); ?><?php echo e(runtimeCustomFieldsRequiredAsterix($field->customfields_required)); ?></label>
    <div class="col-sm-12">
        <input type="text" class="form-control form-control-sm" id="<?php echo e($field->customfields_name); ?>"
            name="<?php echo e($field->customfields_name); ?>"
            value="<?php echo e(customFieldValue($field->customfields_name, $task, 'form')); ?>">
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php /**PATH /var/www/html/application/resources/views/pages/task/components/custom-fields-edit.blade.php ENDPATH**/ ?>