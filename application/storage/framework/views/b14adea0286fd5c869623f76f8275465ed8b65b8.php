<div class="card count-<?php echo e(@count($goals)); ?>" id="goals-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            <?php if(@count($goals) > 0): ?>
            <table id="goal-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        <?php if(config('visibility.goals_col_checkboxes')): ?>
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-goals" name="listcheckbox-goals"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="goals-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-goals">
                                <label for="listcheckbox-goals"></label>
                            </span>
                        </th>
                        <?php endif; ?>
                        <th class="goals_col_added"><?php echo e(cleanLang(__('lang.added_by'))); ?></th>
                        <th class="goals_col_title"><?php echo e(cleanLang(__('lang.title'))); ?></th>
                        <th class="goals_col_tags" style="display:none;"><?php echo e(cleanLang(__('lang.tags'))); ?></th>
                        <th class="goals_col_date"><?php echo e(cleanLang(__('lang.date'))); ?></th>
                        <th class="goals_col_action"><a href="javascript:void(0)"><?php echo e(cleanLang(__('lang.action'))); ?></a></th>
                    </tr>
                </thead>
                <tbody id="goals-td-container">
                    <!--ajax content here-->
                    <?php echo $__env->make('pages.goals.components.table.ajax', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
            <?php endif; ?> <?php if(@count($goals) == 0): ?>
            <!--nothing found-->
            <?php echo $__env->make('notifications.no-results-found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <!--nothing found-->
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH /var/www/html/application/resources/views/pages/goals/components/table/table.blade.php ENDPATH**/ ?>