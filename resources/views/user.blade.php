@extends('layouts.app') 
@section('title') 
{{$name}} Profile | {{$setting->website_name}} 
@endsection 
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3 col-sm-6 profile">
            <div class="card hovercard"> @if ($cover == "nocover.jpg")
                <div class="cardheader" style="background: url('{{ url('/') }}/uploads/covers/nocover.jpg');background-size: cover;background-repeat: no-repeat"> </div> @else
                <div class="cardheader" style="background: url('{{ $cover }}');background-size: cover;background-repeat: no-repeat"> </div> @endif @if ($avatar == "noavatar.jpg")
                <div class="avatar"> <img alt="" src="{{ url('/') }}/uploads/avatars/noavatar.jpg" data-toggle="tooltip" data-placement="top" title="{{$name}} {{Lang::get('profile.profile')}}"> </div> @else
                <div class="avatar"> <img alt="" src="{{$avatar}}" data-toggle="tooltip" data-placement="top" title="{{$name}} {{Lang::get('profile.profile')}}"> </div> @endif
                <div class="info">
                    <div class="title">
                        <h3> {{$name}}
					@if(Auth::check() AND $name === Auth::user()->username)
					<a href="{{ url('/') }}/user/{{ Auth::user()->username }}/edit">({{Lang::get('profile.edit')}})</a>
					@endif
					</h3> </div>
                    <div class="desc">{{Lang::get('profile.member')}} {{$time}}</div>
                </div>
                <div class="bottom"> @if ($facebook != NULL)
                    <a target="_blank" href="{{$facebook}}" class="btn-social facebook"> <i class="fa fa-facebook"></i> <span>Facebook</span> </a> @endif @if ($twitter != NULL)
                    <a target="_blank" href="{{$twitter}}" class="btn-social twitter"> <i class="fa fa-twitter"></i> <span>Twitter</span> </a> @endif
                    <a href="{{url('/user')}}/{{$name}}/likes" class="btn-social send_msg"> <i class="fa fa-thumbs-o-up"></i> <span>{{Lang::get('profile.likes')}}</span> </a>
                </div>
            </div>
        </div>
        <div class="col-md-8 profile-media">
            <div class="recently"> @if(Session::has('no_media'))
                <div class="alert alert-info" role="alert"> {{Session::get('no_media')}} </div> @endif
                <?php
					
					$get_user = DB::table('users')
								->where('username', $name)->first();
					
					$media = App\Media::where('active', 1)
							->where('user_id', $get_user->id)
							->orderBy('id', 'desc')->paginate(9);
				?> @if(count($media) == 0)
                    <div class="alert alert-info" role="alert"> <b>Oops!</b> No media in this page. Please try again later. </div> @else
                    <center>
                        <div class="row" style="margin-bottom: 50px">
                            <div id="boxes"> @foreach ($media as $m)
                                <div class="box col-lg-4 col-sm-6 col-xs-12 pomy_box">
                                    <div class="pomy_media_box"> @if ($m->is_video == 1) <a href="#" class="is_vid_img"><i class="fa fa-video-camera"></i> {{Lang::get('home.is_video')}}</a> @else <a href="#" class="is_vid_img"><i class="fa fa-camera"></i> {{Lang::get('home.is_image')}}</a> @endif
                                        <div class="pomy_image"> <a href="{{url('/')}}/media/{{$m->short_url}}">
								@if ($m->is_video == 1)
								<img src="{{$m->vid_img}}" class="pomy_img img-responsive">
								@else
								<img src="{{$m->pic_url}}" class="pomy_img img-responsive">
								@endif
								</a> </div>
                                        <div class="pomy_title">
                                            <h3>{{$m->title}}</h3> </div>
                                        <div class="pomy_stats">
                                            <?php
								$get_comments = DB::table('comments')
												->where('media_id', $m->id)
												->where('status', 1)->count();
								?> <span style="color: rgb(212, 163, 48);">
								{{$get_comments}}</span> <span> {{Lang::get('home.comments')}}</span>
                                                <?php
								$count_views = DB::table('media_views')
									->where('media_id', $m->id)->count();
								if ($count_views >= 1000) {
									$change_num_format = App\libraries\Helper::thousandsNumberFormat($count_views);
								}else{
									$change_num_format = $count_views;
								}
								?> <span style="color: rgb(212, 163, 48);">
								{{$change_num_format}}</span> <span> {{Lang::get('home.views')}}</span>
                                                    <?php
								$get_votes = DB::table('media_likes')
									->where('media_id', $m->id)->count();
								?> <span style="color: rgb(212, 163, 48);">
								{{$get_votes}}</span> <span> {{Lang::get('home.votes')}}</span> </div>
                                    </div>
                                </div> @endforeach </div>
                            <div class="col-span-12">
                                <div style="display: none;" class="paginate text-center"> {{$media->links()}} </div>
                            </div>
                        </div>
                    </center> @endif </div>
        </div>
    </div>
</div> @endsection