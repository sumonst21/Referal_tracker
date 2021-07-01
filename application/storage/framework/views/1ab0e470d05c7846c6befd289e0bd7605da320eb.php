<?php $__currentLoopData = $goals; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $goal): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!--each row-->
<tr id="goal_<?php echo e($goal->goal_id); ?>">
    <?php if(config('visibility.goals_col_checkboxes')): ?>
    <td class="goals_col_checkbox checkitem" id="goals_col_checkbox_<?php echo e($goal->goal_id); ?>">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-goals-<?php echo e($goal->goal_id); ?>" name="ids[<?php echo e($goal->goal_id); ?>]"
                class="listcheckbox listcheckbox-goals filled-in chk-col-light-blue"
                data-actions-container-class="goals-checkbox-actions-container">
            <label for="listcheckbox-goals-<?php echo e($goal->goal_id); ?>"></label>
        </span>
    </td>
    <?php endif; ?>
    <td class="goals_col_added">
        <img src="<?php echo e(getUsersAvatar($goal->avatar_directory, $goal->avatar_filename)); ?>" alt="user"
            class="img-circle avatar-xsmall">
        <?php echo e($goal->first_name ?? runtimeUnkownUser()); ?>

    </td>
    <td class="goals_col_title">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="<?php echo e(url('/')); ?>/goals/<?php echo e($goal->goal_id); ?>" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title=" ">
            <?php echo e(str_limit($goal->goal_title, 65)); ?>

        </a>
    </td>
    <td class="goals_col_tags" style="display: none;">
        <!--tag-->
        <?php if(count($goal->tags) > 0): ?>
        <?php $__currentLoopData = $goal->tags->take(2); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <span class="label label-outline-default"><?php echo e(str_limit($tag->tag_title, 15)); ?></span>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
        <span>---</span>
        <?php endif; ?>
        <!--/#tag-->

        <!--more tags (greater than tags->take(x) number above -->
        <?php if(count($goal->tags) > 1): ?>
        <?php $tags = $goal->tags; ?>
        <?php echo $__env->make('misc.more-tags', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        <!--more tags-->
    </td>

    <td class="goals_col_date <?php echo e($page[ 'visibility_col_date'] ?? ''); ?> "><?php echo e(runtimeDate($goal->goal_created)); ?>

    </td>
    </td>
    <td class="goals_col_action  actions_column <?php echo e($page[ 'visibility_col_action'] ?? ''); ?> ">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            <?php if($goal->permission_edit_delete_goal): ?>
            <button type="button" title="<?php echo e(cleanLang(__('lang.delete'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="<?php echo e(cleanLang(__('lang.delete_goal'))); ?>" data-confirm-text="<?php echo e(cleanLang(__('lang.are_you_sure'))); ?>"
                data-ajax-type="DELETE" data-url="<?php echo e(url( '/')); ?>/goals/<?php echo e($goal->goal_id); ?> ">
                <i class="sl-icon-trash"></i>
            </button>
            <button type="button" title="<?php echo e(cleanLang(__('lang.edit'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="<?php echo e(urlResource('/goals/'.$goal->goal_id.'/edit')); ?>" data-loading-target="commonModalBody"
                data-modal-title="<?php echo e(cleanLang(__('lang.edit_goal'))); ?>"
                data-action-url="<?php echo e(urlResource('/goals/'.$goal->goal_id.'?ref=list')); ?>" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="goals-td-container">
                <i class="sl-icon-note"></i>
            </button>
            <?php else: ?>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i class="sl-icon-trash"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  <?php echo e(runtimePlaceholdeActionsButtons()); ?>"
                data-toggle="tooltip" title="<?php echo e(cleanLang(__('lang.actions_not_available'))); ?>"><i class="sl-icon-note"></i></span>
            <?php endif; ?>
            <a href="javascript:void(0)" title="<?php echo e(cleanLang(__('lang.view'))); ?>"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal" data-url="<?php echo e(url( '/')); ?>/goals/<?php echo e($goal->goal_id); ?> " data-target="#plainModal"
                data-loading-target="plainModalBody" data-modal-title="">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
    </td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--each row--><?php /**PATH /var/www/html/application/resources/views/pages/goals/components/table/ajax.blade.php ENDPATH**/ ?>