<span class="dropdown">


    @check_role('edit_shipping_companies')
    <a href="javascript:;"
       class="edit m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
       title="Edit">
    <i class="la la-edit"></i>
    </a>
     <a href="javascript:;"
        class="show_countries m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Countries">
    <i class="fa fa-flag"></i>
    </a>
    @endcheck_role

    @check_role('delete_shipping_companies')
    <a href="javascript:;"
       class="delete m-portlet__nav-link btn m-btn m-btn--hover-danger m-btn--icon m-btn--icon-only m-btn--pill"
       title="Delete">
    <i class="la la-remove"></i>
    </a>
    @endcheck_role
</span>