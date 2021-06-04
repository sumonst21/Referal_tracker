<div class="card count-{{ @count($reminders) }}" id="reminders-table-wrapper">
    <div class="card-body">
        <div class="table-responsive">
            @if (@count($reminders) > 0)
            <table id="reminder-foo-addrow" class="table m-t-0 m-b-0 table-hover no-wrap contact-list" data-page-size="10">
                <thead>
                    <tr>
                        @if(config('visibility.reminders_col_checkboxes'))
                        <th class="list-checkbox-wrapper">
                            <!--list checkbox-->
                            <span class="list-checkboxes display-inline-block w-px-20">
                                <input type="checkbox" id="listcheckbox-reminders" name="listcheckbox-reminders"
                                    class="listcheckbox-all filled-in chk-col-light-blue"
                                    data-actions-container-class="reminders-checkbox-actions-container"
                                    data-children-checkbox-class="listcheckbox-reminders">
                                <label for="listcheckbox-reminders"></label>
                            </span>
                        </th>
                        @endif
                        <th class="reminders_col_added">{{ cleanLang(__('lang.added_by')) }}</th>
                        <th class="reminders_col_title">{{ cleanLang(__('lang.title')) }}</th>
                        <!-- <th class="reminders_col_tags">{{ cleanLang(__('lang.tags')) }}</th> -->
                        <th class="reminders_col_date">{{ cleanLang(__('lang.date')) }}</th>
                        <th class="reminders_col_action"><a href="javascript:void(0)">{{ cleanLang(__('lang.action')) }}</a></th>
                    </tr>
                </thead>
                <tbody id="reminders-td-container">
                    <!--ajax content here-->
                    @include('pages.reminders.components.table.ajax')
                    <!--ajax content here-->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="20">
                            <!--load more button-->
                            @include('misc.load-more-button')
                            <!--load more button-->
                        </td>
                    </tr>
                </tfoot>
            </table>
            @endif @if (@count($reminders) == 0)
            <!--nothing found-->
            @include('notifications.no-results-found')
            <!--nothing found-->
            @endif
        </div>
    </div>
</div>