<div class="card count-<?php echo e(@count($reminders)); ?>" id="reminders-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            <?php if(@count($reminders) > 0): ?>
            <table id="reminder-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        <?php if(config('visibility.reminders_col_checkboxes')): ?>
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-reminders" name="listcheckbox-reminders"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="reminders-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-reminders">
                                <label for="listcheckbox-reminders"></label>
                            </span>
                        </th>
                        <?php endif; ?>
                        <th class="reminders_col_added"><?php echo e(cleanLang(__('lang.added_by'))); ?></th>
                        <th class="reminders_col_title"><?php echo e(cleanLang(__('lang.title'))); ?></th>
                        <!-- <th class="reminders_col_tags"><?php echo e(cleanLang(__('lang.tags'))); ?></th> -->
                        <th class="reminders_col_date"><?php echo e(cleanLang(__('lang.date'))); ?></th>
                        <th class="reminders_col_action"><a href="javascript:void(0)"><?php echo e(cleanLang(__('lang.action'))); ?></a></th>
                    </tr>
                </thead>
                <tbody id="reminders-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('pages.reminders.components.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            <?php echo $__env->make('misc.load-more-button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            <?php endif; ?> <?php if(@count($reminders) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /var/www/html/application/resources/views/pages/reminders/components/table/table.blade.php ENDPATH**/ ?>