@extends('layouts.app') 
@section('title') 
 {{ $media->title }} | {{ $setting->website_name }} 
@endsection 
@section('description')
<meta content='{{ $media->description }}' name='description' /> @endsection @section ('og_meta')
<meta property="og:title" content="{{ $media->title }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url('/media') }}/{{ $media->short_url }}" /> @if($media->is_picture == 1)
<meta property="og:image" content="{{ $media->pic_url }}" /> @else
<meta property="og:image" content="{{ $media->vid_img }}" /> @endif
<meta property="og:site_name" content="{{ $setting->website_name }}" />
<meta property="og:description" content="{{ $media->description }}" />
<meta property="article:published_time" content="{{ $media->created_at }}" />
<meta property="article:modified_time" content="{{ $media->updated_at }}" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:title" content="{{ $media->title }}" /> @if($media->is_picture == 1)
<meta name="twitter:image" content="{{ $media->pic_url }}" />
<meta itemprop="image" content="{{ $media->pic_url }}" /> @else
<meta name="twitter:image" content="{{ $media->vid_img }}" />
<meta itemprop="image" content="{{ $media->vid_img }}" /> @endif @endsection @section('content')
<div class="container">
    <div class="row"> @if(Session::has('success'))
        <div class="alert alert-success" role="alert"> {{Session::get('success')}} </div> @endif @if(Session::has('error'))
        <div class="alert alert-danger" role="alert"> {{Session::get('error')}} </div> @endif
        <div class="col-xs-12 col-sm-6 col-md-8 media_content">
            <div class="media_header">
                <?php
				$current_id = $media->id;
				$next_id = $current_id+1;
				$next_id_query = DB::table('media')->where('id', $next_id)->first();
				?> @if ($next_id_query)
                    <div class="next" onclick="window.location.href='{{url('/')}}/media/{{$next_id_query->short_url}}'"> <span>{{ Lang::get('media.next_media') }}</span> </div> @else
                    <div class="next"> <span>{{ Lang::get('media.no_more_media') }}</span> </div> @endif
                    <?php
				$current_id_prev = $media->id;
				$prev_id = $current_id_prev-1;
				$prev_id_query = DB::table('media')->where('id', $prev_id)->first();
				?> @if ($prev_id_query)
                        <div class="prev" onclick="window.location.href='{{url('/')}}/media/{{$prev_id_query->short_url}}'"> <span><i class="fa fa-chevron-left"></i></span> </div> @else
                        <div class="prev"> <span><i class="fa fa-chevron-left"></i></span> </div> @endif
                        <div class="post-title">
                            <h1>
						{{$media->title}}
					</h1> </div>
                        <p class="post-user-info"> <span> by </span> @if ( $media->user_id == 0 ) <a href="#" class="media-account">Anonymous</a> @else
                            <?php
				$user_id = DB::table('users')->where('id', $media->user_id)->first();
				$user_name = $user_id->username;
				?> <a data-toggle="tooltip" data-placement="bottom" href="{{url('/')}}/user/{{$user_name}}" title="{{Lang::get('media.view_account')}} {{$user_name}}" class="media-account">{{$user_name}}</a> @endif
                                <?php
				$media_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $media->created_at)->diffForHumans();
				?> <span class="exact-time">{{ $media_time }}</span> </p>
            </div> @if ($ads->media_top_ad_code)
            <div class="top_media_ad"> {!! $ads->media_top_ad_code !!} </div> @elseif (!$ads->media_top_ad_code AND $ads->media_top_ad_img)
            <div class="top_media_ad"> <img src="{{ $ads->media_top_ad_img }}"> </div> @endif
            <div class="media-item"> @if( $media->is_picture == 1 )
                <div class="is_picture"> <img src="{{$media->pic_url}}"> </div> @elseif($media->is_video == 1) @if( $media->vid_type == 'youtube' )
                <?php
				
					$youtube_id = App\libraries\Helper::getYouTubeIdFromURL($media->vid_url);
					?>
                    <div class="is_video">
                        <object width="100%" height="400" data="http://www.youtube.com/embed/{{$youtube_id}}"> </object>
                    </div> @elseif( $media->vid_type == 'dailymotion' )
                    <?php
					
					$dailymotion_url = $media->vid_url;
					$dailymotion_id = strtok(basename($dailymotion_url), '_');
					?>
                        <iframe frameborder="0" width="100%" height="400" src="http://www.dailymotion.com/embed/video/{{$dailymotion_id}}"> </iframe> @elseif($media->vid_type == 'metacafe')
                        <?php
					
					$metacafe_url = $media->vid_url;
					$metacafe_path = parse_url($metacafe_url, PHP_URL_PATH);
					$pieces = explode('/', $metacafe_path);
					$videoId = $pieces[2];
					?>
                            <iframe width="100%" height="400" src="http://www.metacafe.com/embed/{{$videoId}}/" class="test-video" frameborder="0" allowfullscreen="1"></iframe> @elseif($media->vid_type == 'vimeo')
                            <?php
					
					$vimeo_id = substr(parse_url($media->vid_url, PHP_URL_PATH), 1);
					?>
                                <iframe src="https://player.vimeo.com/video/{{$vimeo_id}}" width="100%" height="400" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen> </iframe> @elseif($media->vid_type == 'vine')
                                <iframe src="{{$media->vid_url}}/card?mute=1" width="100%" height="500" frameborder="0"></iframe> @elseif($media->vid_type == 'upload')
                                <embed id="player" src="http://s3.spruto.org/embed/player.swf" width="100%" height="360" flashvars="set_pl1_title={{$media->title}}&set_pl1_posterUrl={{$media->vid_img}}&set_pl1_video1_url={{$media->vid_url}}&set_pl1_duration=0&set_uiLanguage=en&set_skinName=islands&set_color_scheme=dark&set_color_buttonBg=#333333&set_color_buttonNormal=#FFFFFF&set_color_buttonHover=#4FA9B8" bgcolor="#000000" wmode="opaque" allowscriptaccess="always" type="application/x-shockwave-flash" allowfullscreen="true" allownetworking="external" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"></embed> @endif @endif </div> @if ($ads->media_bottom_ad_code)
            <div class="top_media_ad" style="margin: 20px auto 0px;"> {!! $ads->media_bottom_ad_code !!} </div> @elseif (!$ads->media_bottom_ad_code AND $ads->media_bottom_ad_img)
            <div class="top_media_ad" style="margin: 20px auto 0px;"> <img src="{{ $ads->media_bottom_ad_img }}"> </div> @endif
            <div class="media-details">
                <p class="media-description">
                    <?php
					
					$active_links_description = App\libraries\Helper::active_links($media->description);
				?> {!! $active_links_description !!} </p>
                <div class="right-box">
                    <div class="btn-group">
                        <button style="box-shadow: none; width: 130px;border-radius: 5px 0px 0 5px;" type="button" class="custom_btn btn btn-primary"> <i class="fa fa-cog"></i> {{Lang::get('media.media_options')}} </button>
                        <button style="box-shadow: none;width: 35px;border-radius: 0px 5px 5px 0px;" type="button" class="custom_btn btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="caret"></span> <span class="sr-only">Toggle Dropdown</span> </button>
                        <ul class="dropdown-menu">
                            <li><a href="{{url('/flag/media/')}}/{{$media->short_url}}"><i class="fa fa-flag"></i> {{Lang::get('media.flag_media')}}</a></li>
                            <li><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/media/{{$media->short_url}}"><i class="fa fa-facebook"></i> Share on Facebook</a></li>
                            <li><a target="_blank" href="https://twitter.com/intent/tweet?url={{url('/')}}/media/{{$media->short_url}}&text={{$media->title}}"><i class="fa fa-twitter"></i> Share on Twitter</a></li>
                            <li><a target="_blank" href="https://plus.google.com/share?url={{url('/')}}/media/{{$media->short_url}}"><i class="fa fa-google"></i> Share on Google+</a></li>
                            <li><a target="_blank" href="https://www.reddit.com/submit?url={{url('/')}}/media/{{$media->short_url}}&title={{$media->title}}"><i class="fa fa-reddit"></i> Share on Reddit</a></li>
                        </ul>
                    </div>
                </div>
                <div class="left-box">
                    <?php
					
					$count_likes = DB::table('media_likes')->where('media_id', $media->id)->count();
					?>
                        <form role="form" method="POST" action="{{ url('/')}}/like/{{$media->short_url}}"> {!! csrf_field() !!}
                            <button type="submit" class="vote_btn like_btn btn like btn-danger"><span class="icon-like" aria-hidden="true"></span> {{Lang::get('media.like')}} <span class="likes">{{$count_likes}}</span></button>
                        </form>
                        <div class="info">
                            <?php
					$count_views = DB::table('media_views')->where('media_id', $media->id)->count();
					?> <span>{{$count_views}} {{Lang::get('home.views')}}</span> </div>
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
        <div class="col-xs-6 col-md-4 sidebar_content">
            <div class="sidebar_header">
                <h2>{{Lang::get('media.related_media')}}</h2> </div>
            <?php
			$related_media = App\Media::where('title', 'LIKE', '%' . $media->title . '%')
				->orWhere('category_id', $media->category_id)
				->where('user_id', '!=', 0)
				->take(6)->get();
			?>
                <div class="related_media_box">
                    <center> @if (count($related_media)) @foreach($related_media as $related) @if($related->is_video == 1)
                        <a data-toggle="tooltip" data-placement="top" title="{{$related->title}}" class="related_img" style="background-image:url({{$related->vid_img}});" href="{{url('/')}}/media/{{$related->short_url}}"> </a> @else
                        <a data-toggle="tooltip" data-placement="top" title="{{$related->title}}" class="related_img" style="background-image:url({{$related->pic_url}});" href="{{url('/')}}/media/{{$related->short_url}}"> </a> @endif @endforeach @endif </center>
                </div>
        </div> @if ($ads->home_side_ad_code)
        <div class="col-xs-6 col-md-4 side_ad"> {!! $ads->home_side_ad_code !!} </div> @elseif (!$ads->home_side_ad_code AND $ads->home_side_ad_img)
        <div class="col-xs-6 col-md-4 side_ad"> <img src="{{ $ads->home_side_ad_img }}"> </div> @endif
        <div class="col-xs-12 col-sm-6 col-md-8 comment_content">
            <div class="site_facebook_comment">
                <?php
				
				$count_comments = App\Comment::where('media_id', $media->id)->where('status', 1)->count();
				?>
                    <center>
                        <button id="site_comment"><i class="fa fa-comment-o"></i> {{Lang::get('media.site_comments')}} ({{$count_comments}})</button>
                        <button id="facebook_comment"><i class="fa fa-facebook"></i> {{Lang::get('media.facebook_comments')}} (
                            <a style="color: rgb(230, 230, 230);font-size: 14px;" class='comment-link' expr:href='data:post.addCommentUrl'>
                                <fb:comments-count expr:href='data:post.url' />
                            </a>)</button>
                    </center>
            </div>
            <div id="site"> @if (Auth::check())
                <form role="form" method="POST" action="{{ url('/')}}/comment/add/{{$media->short_url}}"> {!! csrf_field() !!}
                    <p style="text-align: center;">
                        <textarea id="img_description" data-validation="required length" data-validation-length="max200" data-validation-error-msg="The maximum number of characters allowed is 200." name="comment_text" class="type_comment" placeholder="{{Lang::get('media.submit_comment')}}"></textarea>
                    </p> <span style="color: rgb(182, 182, 182); margin-left: 3%;" id="maxlength">200</span>
                    <input value="{{Lang::get('media.add_comment')}}" class="submit_cm" type="submit"> </form>
                <div style="clear: both;"></div> @else
                <div style="width: 95%;margin: 20px auto 15px;" class="alert alert-info" role="alert"> Please <a href="{{url('/login')}}"><b>Sign in</b></a> or <a href="{{url('/register')}}"><b>Sign up</b></a> to add a comment. </div> @endif
                <?php
				$select_media = DB::table('media')->where('short_url', $media->short_url)->first();
				$current_media_id = $select_media->id;
				$get_comments = App\Comment::where('media_id', $current_media_id)
								->where('status', 1)
								->orderBy('id', 'desc')
								->paginate(10);
				?>
                    <div id="boxes"> @foreach ($get_comments as $comment)
                        <div class="box comment_box" id="cm{{$comment->id}}">
                            <div class="comments_info">
                                <div class="left_comment_box">
                                    <?php
						$get_user = DB::table('users')->where('id', $comment->user_id)->first();
						$username = $get_user->username;
						?> <span class="author">
						<a data-toggle="tooltip" data-placement="top" title="{{$username}} Account" href="{{url('/user')}}/{{$username}}"> {{$username}} </a></span> -
                                        <?php
						$change_time = Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $comment->created_at)->diffForHumans();
						?> <span class="time">{{$change_time}}</span> - <span class="flag">
						<a href="{{url('/flag/comment')}}/{{$comment->id}}" data-toggle="tooltip" data-placement="top" title="{{Lang::get('media.flag_comment')}}">
						<i class="fa fa-flag"></i> Flag </a></span> </div>
                                <div style="clear: both;"></div>
                                <div class="comment_para">
                                    <p> {{$comment->comment}} </p>
                                </div>
                            </div>
                        </div> @endforeach </div>
                    <div class="col-span-12">
                        <div style="display: none;" class="paginate text-center"> {{$get_comments->links()}} </div>
                    </div>
            </div>
            <div id="facebook_cm">
                <div class="fb-comments" data-href="{{url('/')}}" data-width="100%" data-numposts="8" data-colorscheme="dark"></div>
            </div>
        </div>
        <div style="clear: both;"></div>
        <div id="footer">
            <center>
                <a href="https://www.facebook.com/sharer/sharer.php?u={{url('/')}}/media/{{$media->short_url}}" class="share_btn btn-facebook"> <i class="fa fa-facebook"></i> </a>
                <a href="https://twitter.com/intent/tweet?url={{url('/')}}/media/{{$media->short_url}}&text={{$media->title}}" class="share_btn btn-twitter"> <i class="fa fa-twitter"></i> </a>
                <a href="https://plus.google.com/share?url={{url('/')}}/media/{{$media->short_url}}" class="share_btn btn-google"> <i class="fa fa-google"></i> </a>
                <a href="whatsapp://send?text={{$media->title}}-{{url('/')}}/media/{{$media->short_url}}" class="share_btn btn-whatsapp"> <i class="fa fa-whatsapp"></i> </a>
                <a href="https://www.reddit.com/submit?url={{url('/')}}/media/{{$media->short_url}}&title={{$media->title}}" class="share_btn btn-reddit"> <i class="fa fa-reddit"></i> </a>
            </center>
        </div>
    </div>
</div> @endsection