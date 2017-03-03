@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Users List</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Users list</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-users" style="line-height: 10px;font-size: 20px;"></i>Users List </div>
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
                                    <th> E-mail </th>
                                    <th> Joined date </th>
                                    <th> Status </th>
                                    <th> Options </th>
                                </tr>
                            </thead>
                            <tbody> @foreach($users_list as $user)
                                <tr class="odd gradeX">
                                    <td> {{$user->id}} </td>
                                    <td> {{$user->username}} </td>
                                    <td> {{$user->email}} </td>
                                    <td>
                                        <?php
$user_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->diffForHumans();
?> {{$user_time}} </td>
                                    <td class="center"> @if($user->status == 0) <span class="label label-sm label-success">Active</span> @elseif ($user->status == 1) <span class="label label-sm label-danger">pending</span> @else <span style="background-color: #ABABAB;" class="label label-sm label-danger">Blocked</span> @endif </td>
                                    <td>
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <a href="{{url('/user')}}/{{$user->username}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Profile" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="fa fa-eye"></i> </a>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/delete/user/{{$user->id}}"> {!! csrf_field() !!}
                                                <button data-toggle="tooltip" data-placement="top" title="Delete User" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-trash"></i> </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr> @endforeach </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection