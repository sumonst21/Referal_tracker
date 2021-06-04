<!--TOP STATS-->
<div id="js-trigger-home-admin-wrapper">
		<div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Admins</a></li>
                                    <li class="breadcrumb-item active">Dashboard</li>
                                </ol>
                            </div>
                            <h4 class="page-title">Dashboard</h4> </div>
                    </div>
                </div>
<?php echo $__env->make('pages.home.admin.widgets.first-row.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('pages.home.admin.widgets.second-row.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('pages.home.admin.widgets.third-row.wrapper', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div><?php /**PATH /var/www/html/application/resources/views/pages/home/admin/wrapper.blade.php ENDPATH**/ ?>