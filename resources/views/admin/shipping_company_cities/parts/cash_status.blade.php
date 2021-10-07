<span class="get_status m-badge {{$cash == 1 ? 'm-badge--primary' : 'm-badge--danger'}} m-badge--wide">
    {{$cash == 1 ? trans('admin.active') : trans('admin.not_active')}}
</span>
<i class='loading hidden fa fa-spin fa-spinner'></i>