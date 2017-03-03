@extends('layouts.app')
@section('title') 
Edit Your Profile | {{$setting->website_name}} 
@endsection 
@section('content')
<div class="container">
    <div class="row edit_user">
        <form enctype="multipart/form-data" action="{{ url('/')}}/user/{{Auth::user()->username}}/edit" method="POST"> {!! csrf_field() !!} @if(Session::has('error'))
            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif @if(Session::has('success'))
            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.edit_username')}}</span>
                <input name="username" value="{{$name}}" type="text" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.edit_email')}}</span>
                <input name="email" value="{{$email}}" type="text" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.edit_password')}}</span>
                <input name="password" placeholder="Keep this field empty if you don't want to change your password" type="password" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.edit_avatar')}}</span>
                <input name="avatar" style="padding: 0px 12px;" type="file" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.edit_cover')}}</span>
                <input name="cover" style="padding: 0px 12px;" type="file" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.facebook_profile')}}</span>
                <input name="facebook" value="{{$facebook}}" type="text" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <div class="input-group"> <span class="input-group-addon" id="basic-addon3">{{Lang::get('profile.twitter_profile')}}</span>
                <input name="twitter" value="{{$twitter}}" type="text" class="form-control edit_username" id="basic-url" aria-describedby="basic-addon3"> </div>
            <br>
            <input name="" type="submit" value="{{Lang::get('profile.save_changes')}}" name="save_profile" class="save_profile"> </form>
    </div>
</div> @endsection