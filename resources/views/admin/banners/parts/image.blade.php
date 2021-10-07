@if( in_array(substr(strrchr($image, '.'), 1) , ['jpg','png','jpeg','gif']))
    <img src="{{$image}}" width="50" height="50">
@else
    <video width="120" height="100" controls>
        <source :src="{{$image}} " type="video/mp4">
        <source :src="{{$image}}" type="video/ogg">
    </video>
@endif