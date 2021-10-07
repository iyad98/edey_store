<span class="dropdown">


    @if(is_null($parent_id))

    @endif
    {{--
        <a href="javascript:;"
           class="change_status m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
           title="Change Status">
    <i class="la la-exchange"></i>
    </a>
        --}}

        @check_role('edit_slider_app')
    <a href="javascript:;"
       class="edit m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
       title="Edit">
    <i class="la la-edit"></i>
    </a>

        @endcheck_role

         @check_role('delete_slider_app')
    <a href="javascript:;"
       class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
       title="Delete">
    <i class="la la-remove"></i>
    </a>

    @endcheck_role
</span>