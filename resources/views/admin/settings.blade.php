@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
Site Settings
</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">General Settings</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-cog" style="line-height: 10px;font-size: 20px;"></i>Site Settings </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> @if(Session::has('success'))
                            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                            <?php
$site_settings = DB::table('settings')->first();
?>
                                <form enctype="multipart/form-data" role="form" method="POST" action="{{ url('/dashboard/settings') }}"> {!! csrf_field() !!}
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Site Title" name="site_title" value="{{$site_settings->website_name}}" type="text"> <span class="help-block">
EX: Darky. </span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Title Description" name="short_description" value="{{$site_settings->title_description}}" type="text"> <span class="help-block">
PMOY | Short Description Here. </span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <textarea class="form-control" placeholder="Site Seo Description" name="seo_description">{{$site_settings->website_description}}</textarea>
                                    </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Site Keywords" name="site_keyword" value="{{$site_settings->website_keywords}}" type="text"> <span class="help-block">
EX: Darky, viral media, funny pictures... </span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Site E-mail" name="site_email" value="{{$site_settings->website_email}}" type="text"> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Max Video Size" name="max_vid_up" value="{{$site_settings->max_vid_mb}}" type="text"> <span class="help-block">
Max video size in MB. Only number, EX: 100</span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Max Image Size" name="max_img_up" value="{{$site_settings->max_img_mb}}" type="text"> <span class="help-block">
Max image size in MB. Only number, EX: 5</span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" placeholder="Number of media per page" name="paginate" value="{{$site_settings->paginate}}" type="text"> <span class="help-block">
Media Per Page, default: 9</span> </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Active AdBlock</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="active_adblock"> @if($site_settings->adblock_detecting == 1)
                                                    <option value="1">Desactive</option>
                                                    <option value="0">Active</option> @else
                                                    <option value="0">Active</option>
                                                    <option value="1">Desactive</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Auto Approve Comments</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="approve_comments"> @if($site_settings->auto_approve_comments == 1)
                                                    <option value="1">Desactive</option>
                                                    <option value="0">Active</option> @else
                                                    <option value="0">Active</option>
                                                    <option value="1">Desactive</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Auto Approve Uploads</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="approve_uploads"> @if($site_settings->auto_approve_posts == 1)
                                                    <option value="1">Desactive</option>
                                                    <option value="0">Active</option> @else
                                                    <option value="0">Active</option>
                                                    <option value="1">Desactive</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Video Uploading</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="allow_vid_up"> @if($site_settings->allow_vid_up == 1)
                                                    <option value="1">Disallow</option>
                                                    <option value="0">Allow</option> @else
                                                    <option value="0">Allow</option>
                                                    <option value="1">Disallow</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Google reCaptcha</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="recaptcha"> @if($site_settings->recaptcha == 1)
                                                    <option value="1">Disactive</option>
                                                    <option value="0">Acitve</option> @else
                                                    <option value="0">Acitve</option>
                                                    <option value="1">Disactive</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Anonymous Submissions</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="anonymous"> @if($site_settings->anonymous == 1)
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Disabled</option> @else
                                                    <option value="0">Disabled</option>
                                                    <option value="1">Enabled</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Adfly API</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="adfly"> @if($site_settings->adfly == 1)
                                                    <option value="1">Enabled</option>
                                                    <option value="0">Disabled</option> @else
                                                    <option value="0">Disabled</option>
                                                    <option value="1">Enabled</option> @endif </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label class="col-md-3 control-label">Default Theme</label>
                                            <div class="col-md-9">
                                                <select class="form-control" name="theme">
                                                    <option selected="" disabled="">Select One</option>
                                                    <option value="dark">Default</option>
                                                    <option value="brown">Brown</option>
                                                    <option value="blue">Blue</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label for="exampleInputFile1">Upload logo</label>
                                            <input id="exampleInputFile1" name="site_logo" type="file">
                                            <p class="help-block"> Recommended size is: (135*45px) </p>
                                        </div>
                                    </div>
                                    <div style="margin-bottom: 10px;" class="col-md-9">
                                        <div class="form-group">
                                            <label for="exampleInputFile1">Upload favicon</label>
                                            <input id="exampleInputFile1" name="site_favicon" type="file"> </div>
                                    </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" name="site_fb" type="text" placeholder="Facebook Page" value="{{$site_settings->facebook_page_id}}"> <span class="help-block">
Facebook page url </span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" name="site_tw" type="text" placeholder="Twitter Page" value="{{$site_settings->twitter_page_id}}"> <span class="help-block">
Twitter page url </span> </div>
                                    <div style="margin-bottom: 30px;" class="col-md-9">
                                        <input class="form-control" name="site_go" type="text" placeholder="Google+ Page" value="{{$site_settings->google_page_id}}"> <span class="help-block">
Google plus page url </span> </div>
                                    <div class="col-md-9">
                                        <button type="submit" class="btn blue btn-block">Save Settings</button>
                                    </div>
                                </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection