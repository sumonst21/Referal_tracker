<div class="row">
    <div class="col-lg-12">
            <div class="p-b-10 text-right"><small><?php echo e(runtimeDate($reminder->reminder_created)); ?></small></div>        
<div class="p-b-30"><?php echo clean($reminder->reminder_description) ?? '---'; ?></div>
    </div>
</div><?php /**PATH /var/www/html/application/resources/views/pages/reminders/components/modals/show-reminder.blade.php ENDPATH**/ ?>