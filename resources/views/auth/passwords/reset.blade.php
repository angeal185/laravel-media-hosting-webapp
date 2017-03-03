@extends('layouts.app')
<?php
$get_settings = DB::table('settings')->where('id', 1)->first(); 
?> @section('title') {{$get_settings->website_name}} | {{$get_settings->title_description}} @endsection @section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default" style="border: none;">
                    <div class="panel-heading" style="color: #C5C5C5;background-color: #292929;border: none;">Reset Password</div>
                    <div class="panel-body" style="background-color: rgb(50, 50, 50);">
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}"> {!! csrf_field() !!}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" style="color: rgb(203, 203, 203);padding-right: 10px;">E-Mail Address</label>
                                <div class="col-md-6">
                                    <input type="email" class="form-control" name="email" style="height: 35px;border-radius: 2px;" value="{{ $email or old('email') }}"> @if ($errors->has('email')) <span class="help-block">
<strong>{{ $errors->first('email') }}</strong>
</span> @endif </div>
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" style="color: rgb(203, 203, 203);padding-right: 10px;">Password</label>
                                <div class="col-md-6">
                                    <input type="password" style="height: 35px;border-radius: 2px;" class="form-control" name="password"> @if ($errors->has('password')) <span class="help-block">
<strong>{{ $errors->first('password') }}</strong>
</span> @endif </div>
                            </div>
                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <label class="col-md-4 control-label" style="color: rgb(203, 203, 203);padding-right: 10px;">Confirm Password</label>
                                <div class="col-md-6">
                                    <input type="password" style="height: 35px;border-radius: 2px;" class="form-control" name="password_confirmation"> @if ($errors->has('password_confirmation')) <span class="help-block">
<strong>{{ $errors->first('password_confirmation') }}</strong>
</span> @endif </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button style="box-shadow: none;background-color: #135e87;border-radius: 2px;width: 100%;margin-left: -8px;" type="submit" class="btn btn-primary"> <i class="fa fa-btn fa-refresh"></i> Reset Password </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div> @endsection
