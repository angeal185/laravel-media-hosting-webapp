@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
Categories Settings
</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Categories settings</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-folder-o" style="line-height: 10px;font-size: 20px;"></i>Categories Settings </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-toolbar"> </div> @if(Session::has('success'))
                        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th class="table-checkbox"> Id </th>
                                    <th> Category name </th>
                                    <th> Pictures stats </th>
                                    <th> Videos stats </th>
                                    <th> Options </th>
                                </tr>
                            </thead>
                            <tbody> @if (count($categories) > 0) @foreach ($categories as $category)
                                <tr class="odd gradeX">
                                    <td> {{ $category->id }} </td>
                                    <td> {{ $category->name }} </td>
                                    <td>
                                        <?php
$cat_id = $category->id;
$pictures_stats = DB::table('media')->where('category_id', $cat_id)
        						 ->where('is_picture', 1)
          						 ->count();
?> {{$pictures_stats}} </td>
                                    <td>
                                        <?php
$cat_id = $category->id;
$videos_stats = DB::table('media')->where('category_id', $cat_id)
        						 ->where('is_video', 1)
          						 ->count();
?> {{$videos_stats}} </td>
                                    <td class="center">
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <a href="{{url('/category')}}/{{$category->name}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Category" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="fa fa-eye"></i> </a>
                                            <a href="{{ url('/dashboard')}}/edit/category/{{$category->id}}" data-toggle="tooltip" data-placement="top" title="Edit Category" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-pencil"></i> </a>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/delete/category/{{$category->id}}"> {!! csrf_field() !!}
                                                <button data-toggle="tooltip" data-placement="top" title="Delete Category" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-trash"></i> </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr> @endforeach @endif </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection
