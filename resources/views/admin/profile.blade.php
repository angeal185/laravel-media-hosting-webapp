@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <div class="row">
            <div style="width: 95%;margin: 0 auto;">
                <div class="row margin-top-20">
                    <div class="col-md-12">
                        <div class="profile-content">
                            <div class="row"> @if(Session::has('success'))
                                <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                                <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                                <div class="col-md-12">
                                    <div class="portlet light">
                                        <div class="portlet-title tabbable-line">
                                            <div class="caption caption-md"> <i class="icon-globe theme-font hide"></i> <span class="caption-subject font-blue-madison bold uppercase">Profile Account</span> </div>
                                            <ul class="nav nav-tabs">
                                                <li class="active"> <a aria-expanded="true" href="#tab_1_1" data-toggle="tab">Personal Info</a> </li>
                                                <li class=""> <a aria-expanded="false" href="#tab_1_2" data-toggle="tab">Change Avatar</a> </li>
                                                <li class=""> <a aria-expanded="false" href="#tab_1_3" data-toggle="tab">Change Password</a> </li>
                                            </ul>
                                        </div>
                                        <div class="portlet-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active" id="tab_1_1">
                                                    <form role="form" method="POST" action="{{ url('/dashboard/profile/info')}}"> {!! csrf_field() !!}
                                                        <div class="form-group">
                                                            <label class="control-label">Username</label>
                                                            <input name="admin_username" value="{{$get_user_info->username}}" class="form-control" type="text"> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Email</label>
                                                            <input name="admin_email" value="{{$get_user_info->email}}" class="form-control" type="text"> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Facebook Profile Url</label>
                                                            <input name="admin_facebook" placeholder="http://www.facebook.com" value="{{$get_user_info->facebook_profile}}" class="form-control" type="text"> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Twitter Profile Url</label>
                                                            <input name="admin_twitter" placeholder="http://www.twitter.com" value="{{$get_user_info->twitter_profile}}" class="form-control" type="text"> </div>
                                                        <div class="margiv-top-10">
                                                            <button type="submit" class="btn green-haze"> Save Changes </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tab_1_2">
                                                    <form role="form" enctype="multipart/form-data" method="POST" action="{{ url('/dashboard/profile/avatar')}}"> {!! csrf_field() !!}
                                                        <div class="form-group">
                                                            <div class="fileinput fileinput-new" data-provides="fileinput">
                                                                <div class="form-group">
                                                                    <label class="control-label">Avatar Image</label>
                                                                    <input name="admin_avatar" type="file"> </div>
                                                                <div class="form-group">
                                                                    <label class="control-label">Cover Image</label>
                                                                    <input name="admin_cover" type="file"> </div>
                                                            </div>
                                                        </div>
                                                        <div class="margin-top-10">
                                                            <button type="submit" class="btn green-haze"> Update </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane" id="tab_1_3">
                                                    <form role="form" method="POST" action="{{ url('/dashboard/profile/password')}}"> {!! csrf_field() !!}
                                                        <div class="form-group">
                                                            <label class="control-label">Current Password</label>
                                                            <input name="old_password" class="form-control" type="password"> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">New Password</label>
                                                            <input name="password" class="form-control" type="password"> </div>
                                                        <div class="form-group">
                                                            <label class="control-label">Re-type New Password</label>
                                                            <input name="password_confirmation" class="form-control" type="password"> </div>
                                                        <div class="margin-top-10">
                                                            <button type="submit" class="btn green-haze"> Change Password </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection