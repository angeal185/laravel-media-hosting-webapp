@extends('layouts.app')
@section('title') 
Notifications | {{$get_settings->website_name}}
@endsection @section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-6 profile">
            <div class="card hovercard">
                <div class="cardheader" style="background: url('{{$get_user->cover}}');background-size: cover;background-repeat: no-repeat"> </div>
                <div class="avatar"> <img alt="" src="{{$get_user->avatar}}" data-toggle="tooltip" data-placement="top" title="{{$get_user->username}} {{Lang::get('profile.profile')}}"> </div>
                <div class="info">
                    <div class="title">
                        <h3>{{$get_user->username}}</h3> </div>
                    <?php
					$time   = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $get_user->created_at)->diffForHumans();
					?>
                        <div class="desc"> {{Lang::get('profile.member')}} {{$time}} </div>
                </div>
                <div class="bottom">
                    <a target="_blank" href="{{ $get_user->facebook_profile }}" class="btn-social facebook"> <i class="fa fa-facebook"></i> <span>Facebook</span> </a>
                    <a target="_blank" href="{{ $get_user->twitter_profile }}" class="btn-social twitter"> <i class="fa fa-twitter"></i> <span>Twitter</span> </a>
                    <a href="{{url('/user')}}/{{$get_user->username}}/likes" class="btn-social send_msg"> <i class="fa fa-thumbs-o-up"></i> <span>{{Lang::get('profile.likes')}}</span> </a>
                </div>
            </div>
        </div>
        <div class="col-md-8 profile-media"> @if(Session::has('success'))
            <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
            <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif @if (count($get_notification) === 0)
            <div class="alert alert-info" role="alert"> <b>Oops!</b> You don't have any new notifications. </div> @else
            <table class="table" style="color: #ddd;">
                <thead>
                    <tr>
                        <th>{{Lang::get('notifications.description')}}</th>
                        <th>{{Lang::get('notifications.date')}}</th>
                        <th>{{Lang::get('notifications.media')}}</th>
                        <th>{{Lang::get('notifications.option')}}</th>
                    </tr>
                </thead>
                <tbody> @foreach($get_notification as $notice)
                    <tr>
                        <td> @if($notice->type == "approve_comment") Your Comment Has Been Approved. @elseif($notice->type == "approve_media") Your Media Has Been Approved. @elseif($notice->type == "like") You have new likes. @elseif($notice->type == "comment") You have new comments. @endif </td>
                        <td>
                            <?php
					$time_notice   = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notice->created_at)->diffForHumans();
					?> {{$time_notice}} </td>
                        <td>
                            <?php
					$get_media = DB::table('media')->where('id', $notice->media_id)->first();
					?> <a href="{{url('/media')}}/{{$get_media->short_url}}">{{$get_media->short_url}}</a> </td>
                        <td>
                            <div class="notification_options"> @if($notice->status == 0)
                                <form role="form" method="POST" action="{{ url('/')}}/mark/notification/{{$notice->id}}"> {!! csrf_field() !!}
                                    <button type="submit" class="mark_as" data-toggle="tooltip" data-placement="top" title="{{Lang::get('notifications.mark')}}"><i class="fa fa-eye"></i></button>
                                </form> @endif </div>
                        </td>
                    </tr> @endforeach </tbody>
            </table>
            <div class="col-span-12">
                <div class="paginate text-center"> {{$get_notification->links()}} </div>
            </div> @endif </div>
    </div>
</div> @endsection