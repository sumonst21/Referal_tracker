<div class="row">

    <div class="col-lg-12">

        <!--title-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.title')) }}*</label>
            <div class="col-sm-12">
                
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="reminder_title"
                    name="reminder_title" value="{{ $reminder->reminder_title ?? '' }}">
            </div>
        </div>

        <!--description-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.description')) }}*</label>
            <div class="col-sm-12">
                <textarea id="reminder_description" name="reminder_description"
                    class="tinymce-textarea hidden">{{ $reminder->reminder_description ?? '' }}</textarea>
            </div>
        </div>

        <!--tags-->
       <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.date')) }}*</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="reminder_date"
                    name="reminder_date" value="{{ $reminder->reminder_date ?? '' }}">
            </div>
        </div>
        <!--/#tags-->


        <!--pass source-->
        <input type="hidden" name="source" value="{{ request('source') }}">

        <!--reminders-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>

        <!--info-->
        @if(request('reminderresource_type') == 'project' && auth()->user()->is_team)
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">{{ cleanLang(__('lang.project_reminders_not_visible_to_client')) }}</div>
            </div>
        </div>
        @endif

    </div>
</div>