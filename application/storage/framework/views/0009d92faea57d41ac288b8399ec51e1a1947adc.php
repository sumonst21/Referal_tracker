<!-- Todays Payments -->
<div class="col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body p-l-15 p-r-15">
            <div class="d-flex p-10 no-block">
                <span class="align-slef-center card-2">
                    <h2 class="m-b-0"><?php echo e($payload['projects']['completed']); ?></h2>
                    <h6 class="text-success m-b-0"><?php echo e(cleanLang(__('lang.projects'))); ?> - <?php echo e(cleanLang(__('lang.completed'))); ?></h6>
                </span>
                <div class="align-self-center display-6 ml-auto bg-success"><i class="mdi mdi-wallet text-white icon-lg"></i>
                </div>
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar bg-success w-100 h-px-3" role="progressbar" aria-valuenow="100" aria-valuemin="0"
                aria-valuemax="100"></div>
        </div>
    </div>
</div><?php /**PATH /var/www/html/application/resources/views/pages/home/client/widgets/first-row/projects-completed.blade.php ENDPATH**/ ?>