@extends('layouts.app')
<?php
$get_settings = DB::table('settings')->where('id', 1)->first(); 
?> @section('title') Create Account | {{$get_settings->website_name}} @endsection @section('content')
    <div class="smart-wrap">
        <div class="smart-forms smart-container wrap-2">
            <form id="contact" role="form" method="POST" action="{{ url('/register') }}"> {!! csrf_field() !!}
                <div class="form-body theme-black">
                    <div class="frm-row">
                        <div class="colm colm6 pad-r30 bdr">
                            <div class="spacer-b30">
                                <div class="tagline"><span>Sign in  With </span></div>
                            </div>
                            <div class="section">
                                <a href="{{ action('Auth\SocialController@redirectToProvider') }}" class="button btn-social facebook span-left block"> <span><i class="fa fa-facebook"></i></span> Facebook </a>
                                <a href="{{ action('Auth\twitterController@redirectToProvider') }}" class="button btn-social twitter span-left block"> <span><i class="fa fa-twitter"></i></span> Twitter </a>
                                <a href="{{ action('Auth\googleController@redirectToProvider') }}" class="button btn-social googleplus span-left block"> <span><i class="fa fa-google-plus"></i></span> Google+ </a>
                            </div>
                        </div>
                        <div class="colm colm6 pad-l30">
                            <div class="spacer-b30">
                                <div class="tagline"><span> OR  Register </span></div>
                            </div>
                            <div class="section">
                                <label for="username" class="field prepend-icon">
                                    <input type="text" data-validation="required" data-validation-error-msg="Username required." name="username" value="{{ old('username') }}" id="username" class="gui-input" placeholder="Enter username">
                                    <label for="username" class="field-icon"><i class="fa fa-user"></i></label>
                                </label> @if ($errors->has('username')) <span class="help-block">
<strong style="color: rgb(180, 96, 96);">{{ $errors->first('username') }}</strong>
</span> @endif </div>
                            <div class="section">
                                <label for="username" class="field prepend-icon">
                                    <input value="{{ old('email') }}" type="text" name="email" id="email" class="gui-input" placeholder="Enter e-mail" data-validation="required email" data-validation-error-msg="Invalid email.">
                                    <label for="email" class="field-icon"><i class="fa fa-envelope"></i></label>
                                </label> @if ($errors->has('email')) <span class="help-block">
<strong style="color: rgb(180, 96, 96);">{{ $errors->first('email') }}</strong>
</span> @endif </div>
                            <div class="section">
                                <label for="password" class="field prepend-icon">
                                    <input data-validation="required" data-validation-error-msg="Password required." type="password" name="password" id="password" class="gui-input" placeholder="Enter password">
                                    <label for="password" class="field-icon"><i class="fa fa-lock"></i></label>
                                </label> @if ($errors->has('password')) <span class="help-block">
<strong style="color: rgb(180, 96, 96);">{{ $errors->first('password') }}</strong>
</span> @endif </div>
                            <div class="section">
                                <label class="switch switch-black block">
                                    <button style="float: right;margin-top: -15px;margin-right: -10px;" type="submit" class="button btn-black">Sign up</button>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div></div> @endsection
