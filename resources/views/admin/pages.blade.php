@extends('admin.app') @section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">
Pages Settings
</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="{{url('dashboard')}}">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="#">Pages settings</a> </li>
            </ul>
            <div class="page-toolbar"> </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet box grey-cascade">
                    <div class="portlet-title">
                        <div class="caption"> <i class="fa fa-file-text-o" style="line-height: 10px;font-size: 20px;"></i>Pages Settings </div>
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
                                    <th> Page name </th>
                                    <th> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="odd gradeX">
                                    <td> 1 </td> @if(count($pages) > 0) @foreach($pages as $page)
                                    <td> {{$page->title}} </td>
                                    <td class="center">
                                        <div style="width: 100%;display: inline-flex;padding: 8px;">
                                            <a href="{{url('/page')}}/{{$page->page_url}}" target="_blank" data-toggle="tooltip" data-placement="top" title="View Page" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="fa fa-eye"></i> </a>
                                            <a href="{{ url('/dashboard')}}/edit/page/{{$page->id}}" data-toggle="tooltip" data-placement="top" title="Edit Page" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-pencil"></i> </a>
                                            <form role="form" method="POST" action="{{ url('/dashboard')}}/delete/page/{{$page->id}}"> {!! csrf_field() !!}
                                                <button data-toggle="tooltip" data-placement="top" title="Delete Page" style="border: medium none;background-color: rgb(92, 92, 92);margin-right: 2px;" class="label label-sm label-success"> <i class="glyphicon glyphicon-trash"></i> </button>
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