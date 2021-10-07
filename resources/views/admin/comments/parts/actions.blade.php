<span class="dropdown">
    <div class="row">
        <div class="col-sm-12">
            @if(($status == 0 || $status == 2) && is_null($deleted_at) )
                <a href="javascript:;" class="approve" style="color: #34bfa3">{{trans('admin.approve')}}</a> |
            @endif
            @if( ($status == 0 || $status == 1)  && is_null($deleted_at) )
                <a href="javascript:;" class="disapprove" style="color: #ffb822">{{trans('admin.disapprove')}}</a> |
            @endif

            @if(is_null($deleted_at))
                <a href="javascript:;" style="color: red" class="delete">{{trans('admin.trash')}}</a>

            @else
                <a href="javascript:;" style="color: #5867dd" class="cancel_delete">{{trans('admin.cancel_trash')}}</a>
            @endif

        </div>
    </div>
</span>