<?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="item_<?php echo e($item->item_id); ?>">
    <?php if(config('visibility.items_col_checkboxes')): ?>
    <td class="items_col_checkbox checkitem" id="items_col_checkbox_<?php echo e($item->item_id); ?>">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-items-<?php echo e($item->item_id); ?>" name="ids[<?php echo e($item->item_id); ?>]"
                class="listcheckbox listcheckbox-items filled-in chk-col-light-blue items-checkbox"
                data-actions-container-class="items-checkbox-actions-container" data-item-id="<?php echo e($item->item_id); ?>"
                data-unit="<?php echo e($item->item_unit); ?>" data-quantity="1" data-description="<?php echo e($item->item_description); ?>"
                data-rate="<?php echo e($item->item_rate); ?>">
            <label for="listcheckbox-items-<?php echo e($item->item_id); ?>"></label>
        </span>
    </td>
    <?php endif; ?>
    <td class="items_col_description" id="items_col_description_<?php echo e($item->item_id); ?>">
        <?php if(config('settings.trimmed_title')): ?>
        <?php echo e(str_limit($item->item_description ?? '---', 45)); ?>

        <?php else: ?>
        <?php echo e($item->item_description); ?>

        <?php endif; ?>
    </td>
    <td class="items_col_rate" id="items_col_rate_<?php echo e($item->item_id); ?>">
        <?php echo e(runtimeMoneyFormat($item->item_rate)); ?>

    </td>
    <td class="items_col_unit" id="items_col_unit_<?php echo e($item->item_id); ?>"><?php echo e($item->item_unit); ?></td>
    <?php if(config('visibility.items_col_category')): ?>
    <td class="items_col_category ucwords" id="items_col_category_<?php echo e($item->item_id); ?>">
        <?php echo e(str_limit($item->category_name ?? '---', 30)); ?></td>
    <?php endif; ?>
    <?php if(config('visibility.items_col_action')): ?>
    <td class="items_col_action actions_column" id="items_col_action_<?php echo e($item->item_id); ?>">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <!--delete-->
            <?php if(config('visibility.action_buttons_delete')): ?>
            <button type="button" title="<?php echo e(cleanLang(__('lang.delete'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="<?php echo e(cleanLang(__('lang.delete_product'))); ?>" data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>"
                data-ajax-type="DELETE" data-url="<?php echo e(url('/')); ?>/items/<?php echo e($item->item_id); ?>">
                <i class="sl-icon-trash"></i>
            </button>
            <?php endif; ?>
            <!--edit-->
            <?php if(config('visibility.action_buttons_edit')): ?>
            <button type="button" title="<?php echo e(cleanLang(__('lang.edit'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(urlResource('/items/'.$item->item_id.'/edit')); ?>" data-loading-target="commonModalBody"
                data-modal-title="<?php echo e(cleanLang(__('lang.edit_product'))); ?>"
                data-action-url="<?php echo e(urlResource('/items/'.$item->item_id.'?ref=list')); ?>" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="items-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <?php endif; ?>
            <!--more button (team)-->
            <?php if(config('visibility.action_buttons_edit') == 'show'): ?>
            <span class="list-table-action dropdown font-size-inherit">
                <button type="button" id="listTableAction" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" title="<?php echo e(cleanLang(__('lang.more'))); ?>"
                    class="data-toggle-action-tooltip btn btn-outline-default-light btn-circle btn-sm">
                    <i class="ti-more"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="listTableAction">
                    <!--actions button - change category-->
                    <a class="dropdown-item actions-modal-button js-ajax-ux-request reset-target-modal-form"
                        href="javascript:void(0)" data-toggle="modal" data-target="#actionsModal"
                        data-modal-title="<?php echo e(cleanLang(__('lang.change_category'))); ?>" data-url="<?php echo e(url('/items/change-category')); ?>"
                        data-action-url="<?php echo e(urlResource('/items/change-category?id='.$item->item_id)); ?>"
                        data-loading-target="actionsModalBody" data-action-method="POST">
                        <?php echo e(cleanLang(__('lang.change_category'))); ?></a>
                    <!--actions button - attach project -->
                </div>
            </span>
            <?php endif; ?>
            <!--more button-->
        </span>
        <!--action button-->
    </td>
    <?php endif; ?>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH /var/www/html/application/resources/views/pages/items/components/table/ajax.blade.php ENDPATH**/ ?>