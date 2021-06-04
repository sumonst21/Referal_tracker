@foreach($goals as $goal)
<!--each row-->
<tr id="goal_{{ $goal->goal_id }}">
    @if(config('visibility.goals_col_checkboxes'))
    <td class="goals_col_checkbox checkitem" id="goals_col_checkbox_{{ $goal->goal_id }}">
        <!--list checkbox-->
        <span class="list-checkboxes display-inline-block w-px-20">
            <input type="checkbox" id="listcheckbox-goals-{{ $goal->goal_id }}" name="ids[{{ $goal->goal_id }}]"
                class="listcheckbox listcheckbox-goals filled-in chk-col-light-blue"
                data-actions-container-class="goals-checkbox-actions-container">
            <label for="listcheckbox-goals-{{ $goal->goal_id }}"></label>
        </span>
    </td>
    @endif
    <td class="goals_col_added">
        <img src="{{ getUsersAvatar($goal->avatar_directory, $goal->avatar_filename) }}" alt="user"
            class="img-circle avatar-xsmall">
        {{ $goal->first_name ?? runtimeUnkownUser() }}
    </td>
    <td class="goals_col_title">
        <a href="javascript:void(0)" class="show-modal-button js-ajax-ux-request" data-toggle="modal"
            data-url="{{ url('/') }}/goals/{{  $goal->goal_id }}" data-target="#plainModal"
            data-loading-target="plainModalBody" data-modal-title=" ">
            {{ str_limit($goal->goal_title, 65) }}
        </a>
    </td>
    <td class="goals_col_tags" style="display: none;">
        <!--tag-->
        @if(count($goal->tags) > 0)
        @foreach($goal->tags->take(2) as $tag)
        <span class="label label-outline-default">{{ str_limit($tag->tag_title, 15) }}</span>
        @endforeach
        @else
        <span>---</span>
        @endif
        <!--/#tag-->

        <!--more tags (greater than tags->take(x) number above -->
        @if(count($goal->tags) > 1)
        @php $tags = $goal->tags; @endphp
        @include('misc.more-tags')
        @endif
        <!--more tags-->
    </td>

    <td class="goals_col_date {{ $page[ 'visibility_col_date'] ?? '' }} ">{{ runtimeDate($goal->goal_created) }}
    </td>
    </td>
    <td class="goals_col_action  actions_column {{ $page[ 'visibility_col_action'] ?? '' }} ">
        <!--action button-->
        <span class="list-table-action dropdown font-size-inherit">
            @if($goal->permission_edit_delete_goal)
            <button type="button" title="{{ cleanLang(__('lang.delete')) }}"
                class="data-toggle-action-tooltip btn btn-outline-danger btn-circle btn-sm confirm-action-danger"
                data-confirm-title="{{ cleanLang(__('lang.delete_goal')) }}" data-confirm-text="{{ cleanLang(__('lang.are_you_sure')) }}"
                data-ajax-type="DELETE" data-url="{{ url( '/') }}/goals/{{  $goal->goal_id }} ">
                <i class="sl-icon-trash"></i>
            </button>
            <button type="button" title="{{ cleanLang(__('lang.edit')) }}"
                class="data-toggle-action-tooltip btn btn-outline-success btn-circle btn-sm edit-add-modal-button js-ajax-ux-request reset-target-modal-form"
                data-toggle="modal" data-target="#commonModal"
                data-url="{{ urlResource('/goals/'.$goal->goal_id.'/edit') }}" data-loading-target="commonModalBody"
                data-modal-title="{{ cleanLang(__('lang.edit_goal')) }}"
                data-action-url="{{ urlResource('/goals/'.$goal->goal_id.'?ref=list') }}" data-action-method="PUT"
                data-action-ajax-class="" data-action-ajax-loading-target="goals-td-container">
                <i class="sl-icon-goal"></i>
            </button>
            @else
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-trash"></i></span>
            <span class="btn btn-outline-default btn-circle btn-sm disabled  {{ runtimePlaceholdeActionsButtons() }}"
                data-toggle="tooltip" title="{{ cleanLang(__('lang.actions_not_available')) }}"><i class="sl-icon-goal"></i></span>
            @endif
            <a href="javascript:void(0)" title="{{ cleanLang(__('lang.view')) }}"
                class="data-toggle-action-tooltip btn btn-outline-info btn-circle btn-sm show-modal-button js-ajax-ux-request"
                data-toggle="modal" data-url="{{ url( '/') }}/goals/{{  $goal->goal_id }} " data-target="#plainModal"
                data-loading-target="plainModalBody" data-modal-title="">
                <i class="ti-new-window"></i>
            </a>
        </span>
        <!--action button-->
    </td>
</tr>
@endforeach
<!--each row-->