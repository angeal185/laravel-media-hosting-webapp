@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Edit Comment</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Edit Comment</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-pencil" style="line-height: 10px;font-size: 20px;"></i>Edit Comment </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar">
                            <form role="form" method="POST" action="{{ url('/dashboard/update/comment/') }}/{{$check_id->id}}"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Comment</label>
                                        <div class="col-md-9">
                                            <textarea name="comment_content" class="form-control">{{$check_id->comment}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin-bottom: 10px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Active Comment</label>
                                        <div class="col-md-9">
                                            <select class="form-control" name="comment_active"> @if($check_id->status == 1)
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