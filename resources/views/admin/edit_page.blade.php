@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Edit Page</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Edit Page</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-pencil-square-o" style="line-height: 10px;font-size: 20px;"></i>Edit Page </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> @if(Session::has('success'))
                            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                            <form role="form" method="POST" action="{{ url('/dashboard/edit/page') }}/{{$check_page->id}}"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <input name="page_title" class="form-control" value="{{$check_page->title}}" type="text"> <span class="help-block">
EX: Privacy Policy. </span> </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <input name="page_url" class="form-control" value="{{$check_page->page_url}}" type="text"> <span class="help-block">
Put only name in the url. EX: privacy_policy. </span> </div>
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <textarea name="page_content">{{$check_page->content}}</textarea>
                                    <script>
                                        CKEDITOR.replace('page_content');
                                    </script>
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" class="btn blue btn-block">Add New Page</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
