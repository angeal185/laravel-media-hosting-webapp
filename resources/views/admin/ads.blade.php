@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Add new ad</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">New Ad</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-paper-plane-o" style="line-height: 10px;font-size: 20px;"></i>New Ad </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> @if(Session::has('message'))
                            <div class="alert alert-success" role="alert"> {{Session::get('message')}} </div> @endif
                            <form action="{{ url('/')}}/dashboard/ads" method="POST"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Header Adsense Code</label>
                                        <div class="col-md-9">
                                            <textarea name="home_top_ad_code" class="form-control" rows="3">{{$ads->home_top_ad_code}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Header Image Url</label>
                                        <div class="col-md-9">
                                            <input name="home_top_ad_img" value="{{$ads->home_top_ad_img}}" class="form-control" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-12">
                                    <hr style="border: 2px solid rgb(239, 239, 239)"> </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Sidebar Adsense Code</label>
                                        <div class="col-md-9">
                                            <textarea name="home_side_ad_code" class="form-control" rows="3">{{$ads->home_side_ad_code}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Sidebar Image Url</label>
                                        <div class="col-md-9">
                                            <input name="home_side_ad_img" class="form-control" value="{{$ads->home_side_ad_img}}" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-12">
                                    <hr style="border: 2px solid rgb(239, 239, 239)"> </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Top Media Adsense Code</label>
                                        <div class="col-md-9">
                                            <textarea name="media_top_ad_code" class="form-control" rows="3">{{$ads->media_top_ad_code}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Top Media Image Url</label>
                                        <div class="col-md-9">
                                            <input name="media_top_ad_img" class="form-control" value="{{$ads->media_top_ad_img}}" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-12">
                                    <hr style="border: 2px solid rgb(239, 239, 239)"> </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bottom Media Adsense Code</label>
                                        <div class="col-md-9">
                                            <textarea name="media_bottom_ad_code" class="form-control" rows="3">{{$ads->media_bottom_ad_code}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Bottom Media Image Url</label>
                                        <div class="col-md-9">
                                            <input name="media_bottom_ad_img" class="form-control" value="{{$ads->media_bottom_ad_img}}" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-12">
                                    <hr style="border: 2px solid rgb(239, 239, 239)"> </div>
                                <div class="col-md-4">
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