@extends('admin.app')
@section('content')

<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Flagged Comments</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Flagged Comments</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-flag" style="line-height: 10px;font-size: 20px;"></i>Flagged Comments </div>
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
                                    <th> Flagged by </th>
                                    <th> Date </th>
                                    <th> Comment </th>
                                    <th> Status </th>
                                    <th> Options </th>
                                </tr>
                            </thead>
                            <tbody> @if (count($flagged_comment) > 0) @foreach ($flagged_comment as $flag)
                                <tr class="odd gradeX">
                                    <td> {{$flag->id}} </td>
                                    <td>
                                        <?php
$check_user = DB::table('users')->where('id', $flag->user_id)->first();
$get_username = $check_user->username;
?> {{$get_username}} </td>
                                    <td>
                                        <?php
$change_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $flag->created_at)->diffForHumans();
?> {{$change_time}} </td>
                                    <td>
                                        <?php
$check_comment = DB::table('comments')->where('id', $flag->comment_id)->first();
$comment_content = $check_comment->comment;
?> {{$comment_content}} </td>
                                    <td class="center"> @if ($check_comment->status == 0) <span class="label label-sm label-danger">pending</span> @else <span class="label label-sm label-success">Approved</span> @endif </td>
                                    <td>
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/mark/flag/{{$flag->id}}"> {!! csrf_field() !!}
                                                <button type="submit" data-toggle="tooltip" data-placement="top" title="Mark as read" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-ok"></i> </button>
                                            </form>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/deletebyflag/comment/{{$flag->comment_id}}"> {!! csrf_field() !!}
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
