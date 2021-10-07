<span class="m-badge m-badge--primary m-badge--wide">
   @if($children_count == 0)
       {{trans('admin.not_found')}}
    @elseif($children_count == 1)
        {{trans('admin.one_banner')}}
    @elseif($children_count == 2)
        {{trans('admin.two_banner')}}
    @else
        {{trans('admin.three_or_more_banner')}}
    @endif
</span>
