<!-- Column -->
<div class="card">
    <!--has logo-->
    <?php if(isset($client['client_logo_folder']) && $client['client_logo_folder'] != ''): ?>
    <div class="card-body profile_header">
        <img src="<?php echo e(url('/')); ?>/storage/logos/clients/<?php echo e($client['client_logo_folder'] ?? '0'); ?>/<?php echo e($client['client_logo_filename'] ?? ''); ?>">
     <button type="button" title="<?php echo e(cleanLang(__('lang.edit'))); ?>"
            class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="<?php echo e(urlResource('/contacts/'.$owner->id.'/edit')); ?>" data-loading-target="commonModalBody"
            data-modal-title="<?php echo e(cleanLang(__('lang.edit_user'))); ?>"
            data-action-url="<?php echo e(urlResource('/contacts/'.$owner->id.'?ref=list')); ?>" data-action-method="PUT"
            data-action-ajax-class="" data-action-ajax-loading-target="contacts-td-container" style="float: right;width: 36px;height: 36px;">
            <i class="sl-icon-note" style="font-size: 18px;"></i>
  </button>   
    </div>
    <?php else: ?>
    <!--no logo -->
    <div class="card-body profile_header client logo-text">
        <?php echo e($client->client_company_name); ?>

    <button type="button" title="<?php echo e(cleanLang(__('lang.edit'))); ?>"
            class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="<?php echo e(urlResource('/contacts/'.$owner->id.'/edit')); ?>" data-loading-target="commonModalBody"
            data-modal-title="<?php echo e(cleanLang(__('lang.edit_user'))); ?>"
            data-action-url="<?php echo e(urlResource('/contacts/'.$owner->id.'?ref=list')); ?>" data-action-method="PUT"
            data-action-ajax-class="" data-action-ajax-loading-target="contacts-td-container" style="float: right;width: 36px;height: 36px;">
            <i class="sl-icon-note" style="font-size: 18px;"></i>
  </button>
    </div>
    <?php endif; ?>
    <div class="card-body p-t-0 p-b-0">
        <?php if(auth()->user()->is_team): ?>
        <div>
            <small class="text-muted"><?php echo e(cleanLang(__('lang.client_name'))); ?></small>
            <h6><?php echo e($client->client_company_name); ?></h6>
            <!--<small class="text-muted"><?php echo e(cleanLang(__('lang.telephone'))); ?></small>
            <h6><?php echo e($client->client_phone); ?></h6>-->
            <small class="text-muted"><?php echo e(cleanLang(__('lang.account_owner'))); ?></small>
            <div class="m-b-10"><img src="<?php echo e(getUsersAvatar($owner->avatar_directory, $owner->avatar_filename)); ?>" alt="user" class="img-circle avatar-xsmall"> <?php echo e($owner->first_name); ?> <?php echo e($owner->last_name); ?></div>
             <?php if($owner->phone): ?>
            <small class="text-muted"><?php echo e(cleanLang(__('lang.telephone'))); ?></small>
            <div><?php echo e($owner->phone); ?></div>
            <?php else: ?>
            <div></div>
            <?php endif; ?>
            <?php if($owner->position): ?>
            <small class="text-muted"><?php echo e(cleanLang(__('lang.position'))); ?></small>
            <div><?php echo e($owner->position); ?></div>
            <?php else: ?>
            <div></div>
            <?php endif; ?>
            <small class="text-muted"><?php echo e(cleanLang(__('lang.account_status'))); ?></small>
            <div>
                <?php if($client->client_status == 'active'): ?>
                <span class="badge badge-pill badge-success"><?php echo e(cleanLang(__('lang.active'))); ?></span>
                <?php else: ?>
                <span class="badge badge-pill badge-danger"><?php echo e(cleanLang(__('lang.suspended'))); ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <div>
        <hr> </div>
    <div class="card-body p-t-0 p-b-0">
        <div>
            <table class="table no-border m-b-0">
                <tbody>
                    <!--invoices-->
                    <tr>
                        <td class="p-l-0 p-t-5"id="fx-client-left-panel-invoices"><?php echo e(cleanLang(__('lang.invoices'))); ?></td>
                        <td class="font-medium p-r-0 p-t-5">
                            <?php echo e(runtimeMoneyFormat($client->sum_invoices_all)); ?>

                            <div class="progress">
                                <div class="progress-bar bg-info  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--payments-->
                    <tr>
                        <td class="p-l-0 p-t-5"><?php echo e(cleanLang(__('lang.payments'))); ?></td>
                        <td class="font-medium p-r-0 p-t-5"><?php echo e(runtimeMoneyFormat($client->sum_all_payments)); ?>

                            <div class="progress">
                                <div class="progress-bar bg-success w-100 h-px-3" role="progressbar"aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--completed projects-->
                    <tr>
                        <td class="p-l-0 p-t-5"><?php echo e(cleanLang(__('lang.completed_projects'))); ?></td>
                        <td class="font-medium p-r-0 p-t-5"><?php echo e($client->count_projects_completed); ?>

                            <div class="progress">
                                <div class="progress-bar bg-warning  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--open projects-->
                    <tr>
                        <td class="p-l-0 p-t-5"><?php echo e(cleanLang(__('lang.open_projects'))); ?></td>
                        <td class="font-medium p-r-0 p-t-5"><?php echo e($client->count_projects_pending); ?>

                            <div class="progress">
                                <div class="progress-bar bg-danger w-100 h-px-3" role="progressbar"aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <hr> </div>
        <!--client address-->
    <div class="card-body p-t-0 p-b-0">
        <small class="text-muted"><?php echo e(cleanLang(__('lang.address'))); ?></small>
        <?php if($client->client_billing_street !== ''): ?>
        <h6><?php echo e($client->client_billing_street); ?></h6>
        <?php endif; ?>
        <?php if($client->client_billing_city !== ''): ?>
        <h6><?php echo e($client->client_billing_city); ?></h6>
        <?php endif; ?>
        <?php if($client->client_billing_state !== ''): ?>
        <h6><?php echo e($client->client_billing_state); ?></h6>
        <?php endif; ?>
        <?php if($client->client_billing_zip !== ''): ?>
        <h6><?php echo e($client->client_billing_zip); ?></h6>
        <?php endif; ?>
        <?php if($client->client_billing_country !== ''): ?>
        <h6><?php echo e($client->client_billing_country); ?></h6>
        <?php endif; ?>
    </div>

    <?php if(config('visibility.client_show_custom_fields')): ?>
    <!--CUSTOMER FIELDS-->
    <div class="m-t-10 m-b-10">
        <hr>
    </div>
    <div class="card-body p-t-0 p-b-0">
        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="x-each-field m-b-18">
            <div class="panel-label p-b-3"><?php echo e($field->customfields_title); ?>

            </div>
            <div class="x-content"><?php echo e(customFieldValue($field->customfields_name, $client, 'text')); ?></div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>


    <div class="d-none last-line">
        <hr> </div>
</div>
<!-- Column --><?php /**PATH /var/www/html/application/resources/views/pages/client/components/misc/leftpanel.blade.php ENDPATH**/ ?>