@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Edit Category</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Edit Category</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-pencil" style="line-height: 10px;font-size: 20px;"></i>Edit Category </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> @if(Session::has('success'))
                            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                            <form enctype="multipart/form-data" role="form" method="POST" action="{{ url('/dashboard/edit/category') }}/{{$check_cat->id}}"> {!! csrf_field() !!}
                                <div style="margin-bottom: 30px;" class="col-md-9">
                                    <div class="form-group">
                                        <label class="col-md-3 control-label">Category Name</label>
                                        <div class="col-md-9">
                                            <input name="category_name" value="{{$check_cat->name}}" class="form-control" type="text"> </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <input class="btn blue btn-block" value="Update Category" type="submit"> </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection