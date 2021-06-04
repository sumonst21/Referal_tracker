@foreach($reminders as $reminder)
<!--each row-->
<tr id="reminder_{{ $reminder->reminder_id }}">
    @if(config('visibility.reminders_col_checkboxes'))
    <td class="reminders_col_checkbox checkitem" id="reminder_col_checkbox_{{ $reminder->reminder_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-reminders-{{ $reminder->reminder_id }}" name="ids[{{ $reminder->reminder_id }}]"
                class="listcheckbox listcheckbox-reminders filled-in chk-col-light-blue"
                data-actions-container-class="reminders-checkbox-actions-container">
            <label for="listcheckbox-reminders-{{ $reminder->reminder_id }}"></label>
        </span>
    </td>
    @endif
    <td class="reminders_col_added">
        <img src="{{ getUsersAvatar($reminder->avatar_directory, $reminder->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        {{ $reminder->first_name ?? runtimeUnkownUser() }}
    </td>
    <td class="reminders_col_title">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="{{ url('/') }}/reminders/{{  $reminder->reminder_id }}" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title=" ">
            {{ str_limit($reminder->reminder_title, 65) }}
        </a>
    </td>
    <!-- <td class="reminders_col_tags"> -->
        <!--tag-->
       <!--  @if(count($reminder->tags) > 0)
        @foreach($reminder->tags->take(2) as $tag)
        <span class="label label-outline-default">{{ str_limit($tag->tag_title, 15) }}</span>
        @endforeach
        @else
        <span>---</span>
        @endif -->
        <!--/#tag-->

        <!-- @if(count($reminder->tags) > 1)
        @php $tags = $reminder->tags; @endphp
        @include('misc.more-tags')
        @endif
    </td> -->

    <td class="reminders_col_date {{ $page[ 'visibility_col_date'] ?? '' }} ">{{ runtimeDate($reminder->reminder_date) }}
    </td>
    </td>
    <td class="reminders_col_action  actions_column {{ $page[ 'visibility_col_action'] ?? '' }} ">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            @if($reminder->permission_edit_delete_reminder)
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_reminder')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url( '/') }}/reminders/{{  $reminder->reminder_id }} ">
                <i class="sl-icon-trash"></i>
            </button>
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/reminders/'.$reminder->reminder_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_reminder')) }}"
                data-action-url="{{ urlResource('/reminders/'.$reminder->reminder_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="reminders-td-container">
                <i class="sl-icon-reminder"></i>
            </button>
            @else
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-trash"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-reminder"></i></span>
            @endif
            <a href="javascript:void(0)" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal" data-url="{{ url( '/') }}/reminders/{{  $reminder->reminder_id }} " data-target="#plainModal"
                data-loading-target="plainModalBody" data-modal-title="">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->