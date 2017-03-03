@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Edit Media</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Edit Media</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-pencil" style="line-height: 10px;font-size: 20px;"></i>Edit Media </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <form role="form" method="POST" action="{{ url('/dashboard/update/media/') }}/{{$check_id->id}}"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Media title</label>
                                        <div class="col-md-9">
                                            <input name="media_title" value="{{$check_id->title}}" class="form-control" type="text"> </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Media Description</label>
                                        <div class="col-md-9">
                                            <textarea name="media_description" class="form-control">{{$check_id->description}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Media URL</label>
                                        <div class="col-md-9"> @if ($check_id->pic_url !== NULL)
                                            <input name="media_pic_url" value="{{$check_id->pic_url}}" class="form-control" type="text"> @else
                                            <input name="media_vid_url" value="{{$check_id->vid_url}}" class="form-control" type="text"> @endif </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Media Category</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="media_category">
                                                <?php
$get_categories = App\Category::all();
?> @foreach ($get_categories as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option> @endforeach </select>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Active Media</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="media_active"> @if($check_id->active == 1)
                                                <option value="1">Active</option>
                                                <option value="0">Desactive</option> @else
                                                <option value="0">Desactive</option>
                                                <option value="1">Active</option> @endif </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input class="btn blue btn-block" value="Save changes" type="submit"> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection