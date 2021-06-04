<!-- action buttons -->
<?php echo $__env->make('misc.list-pages-actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- action buttons -->

<!--tags table-->
<div class="card-embed-fix">
<?php echo $__env->make('pages.tags.components.table.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<!--tags table--><?php /**PATH /var/www/html/application/resources/views/pages/tags/tabswrapper.blade.php ENDPATH**/ ?>