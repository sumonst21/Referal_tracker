<?php $__env->startSection('settings-page'); ?>
<!-- action buttons -->
<?php echo $__env->make('misc.list-pages-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- action buttons -->

<!--heading-->
<form>
    <div class="table-responsive p-b-30">
        <table id="custom-fields" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10"">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?php echo e(cleanLang(__('lang.name'))); ?></th>
                    <th class=" w-15"><?php echo e(cleanLang(__('lang.show_profile'))); ?></th>
            <th class="w-15"><?php echo e(cleanLang(__('lang.show_invoice'))); ?></th>
            <th class="w-13"><?php echo e(cleanLang(__('lang.required'))); ?></th>
            <th class="w-10"><?php echo e(cleanLang(__('lang.enabled'))); ?></th>
            </tr>
            </thead>
            <tbody id="status-td-container">
                <?php $count = 1 ; ?>
                <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td>
                        <?php echo $count++; ?>
                    </td>
                    <!--title-->
                    <td class="p-r-30">
                        <input type="text" class="form-control form-control-sm" id="add_invoices_date"
                            name="customfields_title[<?php echo e($field->customfields_id); ?>]"
                            value="<?php echo e($field->customfields_title); ?>">
                    </td>

                    <!--show on client page-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_show_client_page[<?php echo e($field->customfields_id); ?>]"
                            name="customfields_show_client_page[<?php echo e($field->customfields_id); ?>]"
                            class="filled-in chk-col-light-blue"
                            <?php echo e(runtimePrechecked($field->customfields_show_client_page)); ?>>
                        <label for="customfields_show_client_page[<?php echo e($field->customfields_id); ?>]"></label>
                    </td>
                    <!--show on invoice-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_show_invoice[<?php echo e($field->customfields_id); ?>]"
                            name="customfields_show_invoice[<?php echo e($field->customfields_id); ?>]"
                            class="filled-in chk-col-light-blue"
                            <?php echo e(runtimePrechecked($field->customfields_show_invoice)); ?>>
                        <label for="customfields_show_invoice[<?php echo e($field->customfields_id); ?>]"></label>
                    </td>
                    <!--required-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_required[<?php echo e($field->customfields_id); ?>]"
                            name="customfields_required[<?php echo e($field->customfields_id); ?>]"
                            class="filled-in chk-col-light-blue" <?php echo e(runtimePrechecked($field->customfields_required)); ?>>
                        <label for="customfields_required[<?php echo e($field->customfields_id); ?>]"></label>
                    </td>
                    <!--status-->
                    <td class="td-checkbox">
                        <input type="checkbox" id="customfields_status[<?php echo e($field->customfields_id); ?>]"
                            name="customfields_status[<?php echo e($field->customfields_id); ?>]"
                            class="filled-in chk-col-light-blue" <?php echo e(runtimePrechecked($field->customfields_status)); ?>>
                        <label for="customfields_status[<?php echo e($field->customfields_id); ?>]"></label>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    <div>
        <!--settings documentation help-->
        <a href="" target="_blank" class="btn btn-sm btn-info  help-documentation"><i class="ti-info-alt"></i>
            <?php echo e(cleanLang(__('lang.help_documentation'))); ?></a>

    </div>
    <!--buttons-->
    <div class="text-right">
        <button type="submit" id="commonModalSubmitButton"
            class="btn btn-rounded-x btn-danger waves-effect text-left js-ajax-ux-request"
            data-url="/settings/customfields/clients" data-loading-target="" data-ajax-type="PUT" data-type="form"
            data-on-start-submit-button="disable"><?php echo e(cleanLang(__('lang.save_changes'))); ?></button>
    </div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.settings.ajaxwrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/application/resources/views/pages/settings/sections/customfields/clients.blade.php ENDPATH**/ ?>