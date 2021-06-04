<div class="row">

    <div class="col-lg-12">

        <!--title-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.title'))); ?>*</label>
            <div class="col-sm-12">
                
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="reminder_title"
                    name="reminder_title" value="<?php echo e($reminder->reminder_title ?? ''); ?>">
            </div>
        </div>

        <!--description-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.description'))); ?>*</label>
            <div class="col-sm-12">
                <textarea id="reminder_description" name="reminder_description"
                    class="tinymce-textarea hidden"><?php echo e($reminder->reminder_description ?? ''); ?></textarea>
            </div>
        </div>

        <!--tags-->
       <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required"><?php echo e(cleanLang(__('lang.date'))); ?>*</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="reminder_date"
                    name="reminder_date" value="<?php echo e($reminder->reminder_date ?? ''); ?>">
            </div>
        </div>
        <!--/#tags-->


        <!--pass source-->
        <input type="hidden" name="source" value="<?php echo e(request('source')); ?>">

        <!--reminders-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* <?php echo e(cleanLang(__('lang.required'))); ?></strong></small></div>
            </div>
        </div>

        <!--info-->
        <?php if(request('reminderresource_type') == 'project' && auth()->user()->is_team): ?>
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info"><?php echo e(cleanLang(__('lang.project_reminders_not_visible_to_client'))); ?></div>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div><?php /**PATH /var/www/html/application/resources/views/pages/reminders/components/modals/add-edit-inc.blade.php ENDPATH**/ ?>