@extends('layouts.app')
@section('title') {{$setting->website_name}} | {{$setting->title_description}} @endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-8 home-content">
            @if ($ads->home_top_ad_code)
            <div class="top_ad" id="adblock"> {!! $ads->home_top_ad_code !!} </div> @elseif (!$ads->home_top_ad_code AND $ads->home_top_ad_img)
            <div class="top_ad" id="adblock"> <img style="width: 100%" src="{{ $ads->home_top_ad_img }}"> </div> @endif
            <center>
                <div class="row" style="margin-bottom: 50px">
                    <div id="boxes">
                        @if( count($media) !== 0) @foreach ($media as $m)
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
							$get_comments = DB::table('comments')->where('media_id', $m->id)->where('status', 1)->count();
						?> <span style="color: rgb(212, 163, 48);">
						{{$get_comments}} </span> <span> {{Lang::get('home.comments')}} </span>
                                        <?php
							$count_views = DB::table('media_views')->where('media_id', $m->id)->count();
							if ($count_views >= 1000) {
								$change_num_format = App\libraries\Helper::thousandsNumberFormat($count_views);
							}else{
								$change_num_format = $count_views;
							}
						?> <span style="color: rgb(212, 163, 48);">{{$change_num_format}}</span> <span> {{Lang::get('home.views')}} </span>
                                            <?php
							$get_votes = DB::table('media_likes')->where('media_id', $m->id)->count();
						?> <span style="color: rgb(212, 163, 48);">
						{{$get_votes}} </span> <span> {{Lang::get('home.votes')}}</span> </div>
                            </div>
                        </div>
                        @endforeach @else
                        <div class="no-media" role="alert"> <b>Heads up!</b> No media right now. Please try again later. </div> @endif </div>
                    <div class="col-span-12">
                        <div style="display: none;" class="paginate text-center"> {{$media->links()}} </div>
                    </div>
                </div>
            </center>
        </div>
        <div class="col-xs-6 col-md-4 sidebar">
            <div class="sidebar_box">
                <button style="color: #dbdbdb;box-shadow:none;background-color: #1D1C1C;" onclick="window.location.href='{{url('/')}}/upload'" type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-cloud-upload"></i> {{Lang::get('home.submit_media')}}</button>
            </div>
            @if ($ads->home_side_ad_code)
            <div class="sidebar_box" style="padding: 9px"> {!! $ads->home_side_ad_code !!} </div> @elseif (!$ads->home_side_ad_code AND $ads->home_side_ad_img)
            <div class="sidebar_box" style="padding: 9px"> <img src="{{ $ads->home_side_ad_img }}" class="img-responsive" alt="Responsive image"> </div> @endif
            <div class="tagline"> <span>{{Lang::get('home.follow_us')}}</span> </div>
            <div class="social_icons">
                <ul style="margin-right: 35px" class="social-links clearfix">
                    @if ($setting->facebook_page_id)
                    <li data-toggle="tooltip" data-placement="bottom" title="On Facebook" class="facebook">
                        <a href="{{ $setting->facebook_page_id }}" target="_blank"> <i class="fa fa-facebook"></i> </a>
                    </li> @endif
                    @if($setting->twitter_page_id)
                    <li data-toggle="tooltip" data-placement="bottom" title="On Twitter" class="twitter">
                        <a href="{{ $setting->twitter_page_id }}" target="_blank"> <i class="fa fa-twitter"></i> </a>
                    </li> @endif
                    @if($setting->google_page_id)
                    <li data-toggle="tooltip" data-placement="bottom" title="On Google+" class="google">
                        <a href="{{ $setting->google_page_id }}" target="_blank"> <i class="fa fa-google-plus"></i> </a>
                    </li> @endif </ul>
            </div>
        </div>
    </div>
</div>
@endsection