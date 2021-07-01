<!-- Column -->
<div class="card">
    <!--has logo-->
    @if(isset($client['client_logo_folder']) && $client['client_logo_folder'] != '')
    <div class="card-body profile_header">
        <img src="{{ url('/') }}/storage/logos/clients/{{ $client['client_logo_folder'] ?? '0' }}/{{ $client['client_logo_filename'] ?? '' }}">
     <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
            class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="{{ urlResource('/contacts/'.$owner->id.'/edit') }}" data-loading-target="commonModalBody"
            data-modal-title="{{ cleanLang(__('lang.edit_user')) }}"
            data-action-url="{{ urlResource('/contacts/'.$owner->id.'?ref=list') }}" data-action-method="PUT"
            data-action-ajax-class="" data-action-ajax-loading-target="contacts-td-container" style="float: right;width: 36px;height: 36px;">
            <i class="sl-icon-note" style="font-size: 18px;"></i>
  </button>   
    </div>
    @else
    <!--no logo -->
    <div class="card-body profile_header client logo-text">
        {{ $client->client_company_name }}
    <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
            class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
            data-toggle="modal" data-target="#commonModal"
            data-url="{{ urlResource('/contacts/'.$owner->id.'/edit') }}" data-loading-target="commonModalBody"
            data-modal-title="{{ cleanLang(__('lang.edit_user')) }}"
            data-action-url="{{ urlResource('/contacts/'.$owner->id.'?ref=list') }}" data-action-method="PUT"
            data-action-ajax-class="" data-action-ajax-loading-target="contacts-td-container" style="float: right;width: 36px;height: 36px;">
            <i class="sl-icon-note" style="font-size: 18px;"></i>
  </button>
    </div>
    @endif
    <div class="card-body p-t-0 p-b-0">
        @if(auth()->user()->is_team)
        <div>
            <small class="text-muted">{{ cleanLang(__('lang.client_name')) }}</small>
            <h6>{{ $client->client_company_name }}</h6>
            <!--<small class="text-muted">{{ cleanLang(__('lang.telephone')) }}</small>
            <h6>{{ $client->client_phone }}</h6>-->
            <small class="text-muted">{{ cleanLang(__('lang.account_owner')) }}</small>
            <div class="m-b-10"><img src="{{ getUsersAvatar($owner->avatar_directory, $owner->avatar_filename) }}" alt="user" class="img-circle avatar-xsmall"> {{ $owner->first_name }} {{ $owner->last_name }}</div>
             @if($owner->phone)
            <small class="text-muted">{{ cleanLang(__('lang.telephone')) }}</small>
            <div>{{ $owner->phone }}</div>
            @else
            <div></div>
            @endif
            @if($owner->position)
            <small class="text-muted">{{ cleanLang(__('lang.position')) }}</small>
            <div>{{ $owner->position }}</div>
            @else
            <div></div>
            @endif
            <small class="text-muted">{{ cleanLang(__('lang.account_status')) }}</small>
            <div>
                @if($client->client_status == 'active')
                <span class="badge badge-pill badge-success">{{ cleanLang(__('lang.active')) }}</span>
                @else
                <span class="badge badge-pill badge-danger">{{ cleanLang(__('lang.suspended')) }}</span>
                @endif
            </div>
        </div>
        @endif
    </div>
    <div>
        <hr> </div>
    <div class="card-body p-t-0 p-b-0">
        <div>
            <table class="table no-border m-b-0">
                <tbody>
                    <!--invoices-->
                    <tr>
                        <td class="p-l-0 p-t-5"id="fx-client-left-panel-invoices">{{ cleanLang(__('lang.invoices')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">
                            {{ runtimeMoneyFormat($client->sum_invoices_all) }}
                            <div class="progress">
                                <div class="progress-bar bg-info  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--payments-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.payments')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ runtimeMoneyFormat($client->sum_all_payments) }}
                            <div class="progress">
                                <div class="progress-bar bg-success w-100 h-px-3" role="progressbar"aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--completed projects-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.completed_projects')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ $client->count_projects_completed }}
                            <div class="progress">
                                <div class="progress-bar bg-warning  w-100 h-px-3" role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                            </div>
                        </td>
                    </tr>
                    <!--open projects-->
                    <tr>
                        <td class="p-l-0 p-t-5">{{ cleanLang(__('lang.open_projects')) }}</td>
                        <td class="font-medium p-r-0 p-t-5">{{ $client->count_projects_pending }}
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
        <small class="text-muted">{{ cleanLang(__('lang.address')) }}</small>
        @if($client->client_billing_street !== '')
        <h6>{{ $client->client_billing_street }}</h6>
        @endif
        @if($client->client_billing_city !== '')
        <h6>{{ $client->client_billing_city }}</h6>
        @endif
        @if($client->client_billing_state !== '')
        <h6>{{ $client->client_billing_state }}</h6>
        @endif
        @if($client->client_billing_zip !== '')
        <h6>{{ $client->client_billing_zip }}</h6>
        @endif
        @if($client->client_billing_country !== '')
        <h6>{{ $client->client_billing_country }}</h6>
        @endif
    </div>

    @if(config('visibility.client_show_custom_fields'))
    <!--CUSTOMER FIELDS-->
    <div class="m-t-10 m-b-10">
        <hr>
    </div>
    <div class="card-body p-t-0 p-b-0">
        @foreach($fields as $field)
        <div class="x-each-field m-b-18">
            <div class="panel-label p-b-3">{{ $field->customfields_title }}
            </div>
            <div class="x-content">{{ customFieldValue($field->customfields_name, $client, 'text') }}</div>
        </div>
        @endforeach
    </div>
    @endif


    <div class="d-none last-line">
        <hr> </div>
</div>
<!-- Column -->