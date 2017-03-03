@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
System Stats
</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">System Stats</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-bar-chart" style="line-height: 10px;font-size: 20px;"></i> System Stats </div>
                        <div class="tools">
                            <a href="javascript:;" class="collapse"> </a>
                        </div>
                    </div>
                    <div class="portlet-body"> @if(Session::has('success'))
                        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
                        <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
                        <a href="{{ url('/dashboard') }}/clear/stats" class="btn red"> <i class="fa fa-trash"></i> Clear Logs </a>
                        <div class="table-toolbar">
                            <div class="row"> </div>
                        </div>
                        <table class="table table-striped table-bordered table-hover" id="sample_1">
                            <thead>
                                <tr>
                                    <th class="table-checkbox"> Id </th>
                                    <th> Ip Address </th>
                                    <th> Country </th>
                                    <th> Device </th>
                                    <th> Browser </th>
                                    <th> Platform </th>
                                    <th> Last Active </th>
                                </tr>
                            </thead>
                            <tbody> @if (count ($all_stats) > 0) @foreach ($all_stats as $stats)
                                <tr class="odd gradeX">
                                    <td> {{$stats->id}} </td>
                                    <td> {{$stats->ip_address}} </td>
                                    <td> <img src="{{url('/')}}/themes/dark/img/flags/{{$stats->country_code}}.png"> {{$stats->country_name}} </td>
                                    <td> @if ($stats->device == "Computer") <i style="font-size: 13px;padding-right: 11px;" class="fa fa-desktop"></i> Computer @else <i style="font-size: 20px;padding-right: 19px;" class="fa fa-mobile"></i> Phone @endif </td>
                                    <td class="center"> {{$stats->browser}} </td>
                                    <td class="center"> {{$stats->platform}} </td>
                                    <td class="center">
                                        <?php
$stats_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $stats->created_at)->diffForHumans();
?> {{$stats_time}} </td>
                                </tr> @endforeach @endif </tbody>
                        </table>
                        <div class="col-span-12">
                            <div class="paginate text-center"> {{$all_stats->links()}} </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> @endsection