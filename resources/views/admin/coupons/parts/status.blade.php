<span class="get_status m-badge {{status_coupon()[$status]['class']}} m-badge--wide">
    {{status_coupon()[$status]['title']}}
</span>

@if($is_automatic)
<span style="margin-top: 8px;" class="get_status m-badge m-badge--primary m-badge--wide">
    {{trans('admin.is_automatic')}}
</span>
@endif

<i class='loading hidden fa fa-spin fa-spinner'></i>