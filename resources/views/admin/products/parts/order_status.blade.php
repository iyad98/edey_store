
<select id="select_product_status_{{$id}}"
        class="form-control " >
    @foreach(trans_order_status() as $key=>$value)
        <option @if($order_status == $key) selected @endif value="{{$key}}">{{$value}}</option>
    @endforeach
</select>
<input  type="hidden" value="{{$id}}">
<br>
<button type="submit"  class="btn btn-success btn-sm product_change_status">حفظ الحالة</button>
<span class="dropdown">

    <a href="javascript:;"
       class="add_note_product m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill"
       title="Change Status">
    <i class="la la-sticky-note"></i>
    </a>


</span>

