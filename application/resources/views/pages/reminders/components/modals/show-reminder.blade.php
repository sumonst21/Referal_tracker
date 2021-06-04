<div class="row">
    <div class="col-lg-12">
            <div class="p-b-10 text-right"><small>{{ runtimeDate($reminder->reminder_created) }}</small></div>        
<div class="p-b-30">{!! clean($reminder->reminder_description) ?? '---' !!}</div>
    </div>
</div>