<div class="row">
    <div class="col-sm-3">
        <img src="{{$user->image}}" width="50" height="50">
    </div>
    <div class="col-sm-9">
        {{$user->first_name ." " .$user->last_name}}
        <br>
        {{$user->email}}
    </div>
</div>