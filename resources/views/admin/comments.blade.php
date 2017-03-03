@extends('admin.app')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Comments Settings</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Comments settings</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-comments" style="line-height: 10px;font-size: 20px;"></i>Comments Settings </div>
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
                                    <th> Username </th>
                                    <th> Date </th>
                                    <th> Comment </th>
                                    <th> Status </th>
                                    <th> Options </th>
                                </tr>
                            </thead>
                            <tbody> @if ( count($all_comments) > 0 ) @foreach ($all_comments as $comment)
                                <tr class="odd gradeX">
                                    <td> {{$comment->id}} </td>
                                    <td>
                                        <?php
							$check_user = DB::table('users')->where('id', $comment->user_id)->first();
							$get_username = $check_user->username;
							?> {{$get_username}} </td>
                                    <td>
                                        <?php
							$change_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans();
							?> {{$change_time}} </td>
                                    <td>
                                        <?php
							$check_media = DB::table('media')->where('id', $comment->media_id)->first();
							$media_url = $check_media->short_url;
							?> {{$comment->comment}} </td>
                                    <td class="center"> @if ($comment->status == 0) <span class="label label-sm label-danger">pending</span> @else <span class="label label-sm label-success">Approved</span> @endif </td>
                                    <td>
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <a href="{{url('/media')}}/{{$media_url}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Media" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="fa fa-eye"></i> </a>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/approve/comment/{{$comment->id}}"> {!! csrf_field() !!}
                                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Approve Comment" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-ok"></i> </button>
                                            </form>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/edit/comment/{{$comment->id}}"> {!! csrf_field() !!}
                                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Edit Comment" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-pencil"></i> </button>
                                            </form>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/delete/comment/{{$comment->id}}"> {!! csrf_field() !!}
                                                <button data-toggle="tooltip" data-placement="top" title="Delete Comment" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-trash"></i> </button>
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
