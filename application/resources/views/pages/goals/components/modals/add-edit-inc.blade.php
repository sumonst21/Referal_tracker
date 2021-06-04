<div class="row">
    <div class="col-lg-12">

        <!--title-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.title')) }}*</label>
            <div class="col-sm-12">
                <input type="text" class="form-control form-control-sm" autocomplete="off" id="goal_title"
                    name="goal_title" value="{{ $goal->goal_title ?? '' }}">
            </div>
        </div>

        <!--description-->
        <div class="form-group row">
            <label class="col-sm-12 text-left control-label col-form-label required">{{ cleanLang(__('lang.description')) }}*</label>
            <div class="col-sm-12">
                <textarea id="goal_description" name="goal_description"
                    class="tinymce-textarea hidden">{{ $goal->goal_description ?? '' }}</textarea>
            </div>
        </div>

        <!--tags-->
        <div class="form-group row" style="display:none;">
            <label class="col-sm-12 text-left control-label col-form-label">{{ cleanLang(__('lang.tags')) }}</label>
            <div class="col-sm-12">
                <select name="tags" id="tags"
                    class="form-control form-control-sm select2-multiple {{ runtimeAllowUserTags() }} select2-hidden-accessible"
                    multiple="multiple" tabindex="-1" aria-hidden="true">
                    <!--array of selected tags-->
                    @if(isset($page['section']) && $page['section'] == 'edit')
                    @foreach($goal->tags as $tag)
                    @php $selected_tags[] = $tag->tag_title ; @endphp
                    @endforeach
                    @endif
                    <!--/#array of selected tags-->
                    @foreach($tags as $tag)
                    <option value="{{ $tag->tag_title }}"
                        {{ runtimePreselectedInArray($tag->tag_title ?? '', $selected_tags  ?? []) }}>{{ $tag->tag_title }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <!--/#tags-->


        <!--pass source-->
        <input type="hidden" name="source" value="{{ request('source') }}">

        <!--goals-->
        <div class="row">
            <div class="col-12">
                <div><small><strong>* {{ cleanLang(__('lang.required')) }}</strong></small></div>
            </div>
        </div>

        <!--info-->
        @if(request('goalresource_type') == 'project' && auth()->user()->is_team)
        <div class="row">
            <div class="col-12">
                <div class="alert alert-info">{{ cleanLang(__('lang.project_goals_not_visible_to_client')) }}</div>
            </div>
        </div>
        @endif

    </div>
</div>