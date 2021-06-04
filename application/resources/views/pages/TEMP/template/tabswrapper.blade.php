<!-- action buttons -->
@include('misc.list-pages-actions')
<!-- action buttons -->

<!--stats panel-->
@if(auth()->user()->is_team)
<div id="foos-stats-wrapper" class="stats-wrapper card-embed-fix">
@if (@count($foos) > 0) @include('misc.list-pages-stats') @endif
</div>
@endif
<!--stats panel-->

<!--foos table-->
<div class="card-embed-fix">
@include('pages.foos.components.table.wrapper')
</div>
<!--foos table-->