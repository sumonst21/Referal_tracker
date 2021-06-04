<!-- action buttons -->
<?php echo $__env->make('misc.list-pages-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- action buttons -->

<!--goals table-->
<div class="card-embed-fix">
<?php echo $__env->make('pages.goals.components.table.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!--goals table--><?php /**PATH /var/www/html/application/resources/views/pages/goals/tabswrapper.blade.php ENDPATH**/ ?>