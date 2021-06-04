<!--CRUMBS CONTAINER (RIGHT)-->
<div class="col-md-12  col-lg-6 align-self-center text-right parent-page-actions p-b-9"
    id="list-page-actions-container">
    <div id="list-page-actions">


        <!--client actions-->
        @if(config('visibility.client_actions_edit'))
        <span class="dropdown">
            <button type="button" data-toggle="dropdown" title="" aria-haspopup="true" aria-expanded="false"
                class="data-toggle-tooltip list-actions-button btn btn-page-actions waves-effect waves-dark"
                data-original-title="Edit" aria-describedby="tooltip211004">
                <i class="sl-icon-note"></i>
            </button>
            <div class="dropdown-menu" aria-labelledby="listTableAction" style="">
                <a class="dropdown-item edit-add-modal-button js-ajax-ux-request reset-target-modal-form hidden"
                    href="javascript:void(0)" data-toggle="modal" data-target="#commonModal"
                    data-url="http://growcrm.co.zw/clients/20/edit" data-loading-target="commonModalBody"
                    data-modal-title="Edit Client" data-action-url="http://growcrm.co.zw/clients/20?ref=list"
                    data-action-method="PUT" data-action-ajax-loading-target="clients-td-container">
                    @lang('lang.update_credit_card')</a>
                <!--upload logo-->
                <a class="dropdown-item js-ajax-ux-request" href="javascript:void(0)"
                    data-url="{{ url('/subscriptions/'.$subscription->subscription_id.'/cancel') }}">
                    @lang('lang.cancel_subscription')</a>
            </div>
        </span>
        @endif

        <!--delete subscription-->
        @if(config('visibility.delete_button'))
        <!--delete-->
        <button type="button" data-toggle="tooltip" title="{{ cleanLang(__('lang.delete_subscription')) }}"
            class="list-actions-button btn btn-page-actions waves-effect waves-dark confirm-action-danger"
            data-confirm-title="{{ cleanLang(__('lang.delete_subscription')) }}"
            data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}" data-ajax-type="DELETE"
            data-url="{{ url('/subscriptions/'.$subscription->subscription_id.'?source=page') }}"><i
                class="sl-icon-trash"></i></button>
        @endif
    </div>
</div>
<!-- action buttons -->