@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
Media Settings
</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Media Settings</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-cog" style="line-height: 10px;font-size: 20px;"></i>Media Settings </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body"> @if(Session::has('success'))
                        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th class="table-checkbox"> Id </th>
                                    <th> Title </th>
                                    <th> Type </th>
                                    <th> Category </th>
                                    <th> Date </th>
                                    <th> Submited by </th>
                                    <th> Status </th>
                                    <th style="width: 15%;"> Options </th>
                                </tr>
                            </thead>
                            <tbody> @if (count($all_media) > 0) @foreach($all_media as $media)
                                <tr class="odd gradeX">
                                    <td> {{$media->id}} </td>
                                    <td> {{$media->title}} </td>
                                    <td> @if ($media->is_video == 1)
                                        <a style="box-shadow: none;background-color: rgb(239, 199, 85);" href="javascript:;" class="btn btn-sm blue"> <span style="height: 85px; width: 85px; top: -27.4px; left: 35.5px;" class="md-click-circle md-click-animate">
</span> <i class="icon-camcorder"></i> Video </a> @else
                                        <a style="box-shadow: none;background-color: rgb(37, 150, 180);" href="javascript:;" class="btn btn-sm blue"> <span style="height: 85px; width: 85px; top: -27.4px; left: 35.5px;" class="md-click-circle md-click-animate">
</span> <i class="icon-camera"></i> Image </a> @endif </td>
                                    <td>
                                        <?php
$cat_id = DB::table('categories')->where('id', $media->category_id)->first();
$cat_name = $cat_id->name;
?> {{$cat_name}} </td>
                                    <td class="center">
                                        <?php
$media_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $media->created_at)->diffForHumans();
?> {{$media_time}} </td>
                                    <td class="center">
                                        <?php
if ($media->user_id == 0) {
	$user_name = 'Anonymous';
}else{
	$user_id = DB::table('users')->where('id', $media->user_id)->first();
	$user_name = $user_id->username;
}

?> {{$user_name}} </td>
                                    <td class="center"> @if($media->active == 0) <span class="label label-sm label-danger">pending</span> @else <span class="label label-sm label-success">Approved</span> @endif </td>
                                    <td>
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <a href="{{url('/media')}}/{{$media->short_url}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Media" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="fa fa-eye"></i> </a>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/approve/media/{{$media->id}}"> {!! csrf_field() !!}
                                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Approve Media" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-ok"></i> </button>
                                            </form>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/edit/media/{{$media->id}}"> {!! csrf_field() !!}
                                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Edit Media" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-pencil"></i> </button>
                                            </form>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/delete/media/{{$media->id}}"> {!! csrf_field() !!}
                                                <button data-toggle="tooltip" data-placement="top" title="Delete Media" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-trash"></i> </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr> @endforeach @endif </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-span-12">
                    <div class="paginate text-center"> {{$all_media->links()}} </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection