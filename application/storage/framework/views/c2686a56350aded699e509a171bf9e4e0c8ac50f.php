<?php $__currentLoopData = $reminders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reminder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="reminder_<?php echo e($reminder->reminder_id); ?>">
    <?php if(config('visibility.reminders_col_checkboxes')): ?>
    <td class="reminders_col_checkbox checkitem" id="reminder_col_checkbox_<?php echo e($reminder->reminder_id); ?>">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-reminders-<?php echo e($reminder->reminder_id); ?>" name="ids[<?php echo e($reminder->reminder_id); ?>]"
                class="listcheckbox listcheckbox-reminders filled-in chk-col-light-blue"
                data-actions-container-class="reminders-checkbox-actions-container">
            <label for="listcheckbox-reminders-<?php echo e($reminder->reminder_id); ?>"></label>
        </span>
    </td>
    <?php endif; ?>
    <td class="reminders_col_added">
        <img src="<?php echo e(getUsersAvatar($reminder->avatar_directory, $reminder->avatar_filename)); ?>" alt="user"
            class="img-circle avatar-xsmall">
        <?php echo e($reminder->first_name ?? runtimeUnkownUser()); ?>

    </td>
    <td class="reminders_col_title">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="<?php echo e(url('/')); ?>/reminders/<?php echo e($reminder->reminder_id); ?>" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title=" ">
            <?php echo e(str_limit($reminder->reminder_title, 65)); ?>

        </a>
    </td>
    <!-- <td class="reminders_col_tags"> -->
        <!--tag-->
       <!--  <?php if(count($reminder->tags) > 0): ?>
        <?php $__currentLoopData = $reminder->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="label label-outline-default"><?php echo e(str_limit($tag->tag_title, 15)); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <span>---</span>
        <?php endif; ?> -->
        <!--/#tag-->

        <!-- <?php if(count($reminder->tags) > 1): ?>
        <?php $tags = $reminder->tags; ?>
        <?php echo $__env->make('misc.more-tags', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </td> -->

    <td class="reminders_col_date <?php echo e($page[ 'visibility_col_date'] ?? ''); ?> "><?php echo e(runtimeDate($reminder->reminder_date)); ?>

    </td>
    </td>
    <td class="reminders_col_action  actions_column <?php echo e($page[ 'visibility_col_action'] ?? ''); ?> ">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <?php if($reminder->permission_edit_delete_reminder): ?>
            <button type="button" title="<?php echo e(cleanLang(__('lang.delete'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="<?php echo e(cleanLang(__('lang.delete_reminder'))); ?>" data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>"
                data-ajax-type="DELETE" data-url="<?php echo e(url( '/')); ?>/reminders/<?php echo e($reminder->reminder_id); ?> ">
                <i class="sl-icon-trash"></i>
            </button>
            <button type="button" title="<?php echo e(cleanLang(__('lang.edit'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(urlResource('/reminders/'.$reminder->reminder_id.'/edit')); ?>" data-loading-target="commonModalBody"
                data-modal-title="<?php echo e(cleanLang(__('lang.edit_reminder'))); ?>"
                data-action-url="<?php echo e(urlResource('/reminders/'.$reminder->reminder_id.'?ref=list')); ?>" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="reminders-td-container">
                <i class="sl-icon-reminder"></i>
            </button>
            <?php else: ?>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i class="sl-icon-trash"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i class="sl-icon-reminder"></i></span>
            <?php endif; ?>
            <a href="javascript:void(0)" title="<?php echo e(cleanLang(__('lang.view'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal" data-url="<?php echo e(url( '/')); ?>/reminders/<?php echo e($reminder->reminder_id); ?> " data-target="#plainModal"
                data-loading-target="plainModalBody" data-modal-title="">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH /var/www/html/application/resources/views/pages/reminders/components/table/ajax.blade.php ENDPATH**/ ?>