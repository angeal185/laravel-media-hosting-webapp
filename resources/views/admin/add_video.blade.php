@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">New Video</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">New Video</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-video-camera" style="line-height: 10px;font-size: 20px;"></i>New Video </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> @if(Session::has('success'))
                            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                            <form role="form" method="POST" action="{{ url('/dashboard/media/video') }}"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Video Title</label>
                                        <div class="col-md-9">
                                            <input name="vid_title" class="form-control" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Category</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="vid_categories"> @foreach (App\Category::all() as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option> @endforeach </select>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Video URL</label>
                                        <div class="col-md-9">
                                            <input name="video_url" class="form-control" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Video Description</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="vid_description"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input class="btn blue btn-block" value="Add Video" type="submit"> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection