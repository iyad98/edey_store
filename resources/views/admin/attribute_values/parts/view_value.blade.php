<div>

    @if($attribute_key == 'color')
        <div  style="background-color: {{$value}};width: 35px;height: 35px;margin: auto"></div>
    @elseif($attribute_key == 'image')
        <img src="{{url('uploads/attribute_values')."/".$value}}" width="50" height="50">
    @else
        {{$value}}
    @endif

</div>