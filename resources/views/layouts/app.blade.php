<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<?php
$get_settings = DB::table('settings')->where('id', 1)->first();
$favicon      = $get_settings->favicon;
$logo         = $get_settings->logo;
$adblock      = $get_settings->adblock_detecting;
$description  = $get_settings->website_description;
$keywords     = $get_settings->website_keywords;
$site_title   = $get_settings->website_name;
$theme        = $get_settings->theme;
?>
<title>@yield('title')</title>
@if ($__env->yieldContent('description')) @yield('description') @else
<meta content='{{$description}}' name='description' /> @endif
<meta content='{{$keywords}}' name='keywords' />
<meta content='global' name='distribution' />
<meta content='6 days' name='revisit' />
<meta content='6 days' name='revisit-after' />
<meta content='document' name='resource-type' />
<meta content='all' name='audience' />
<meta content='all' name='robots' />
<meta content='index, follow' name='robots' />
<meta content='{{$site_title}}' name='author' />
<meta content='en' name='language' />
@if (trim($__env->yieldContent('og_meta'))) @yield('og_meta') @endif
@if ($favicon == "nofavicon.png")
<link rel="icon" href="{{ url('/') }}/uploads/settings/nofavicon.png"> @else
<link rel="icon" href="{{$favicon}}"> @endif
@include('includes.front.css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<noscript><meta http-equiv="refresh" content="0; url=./js" /></noscript>
@if($adblock == 1) @include('includes.front.adblock') @endif
</head>
<body id="app-layout">
    <div id="fb-root"></div>
	@include('includes.front.nav')
    
    <?php $media = DB::table('media')->where('active', 1)->where('user_id', '!=', 0)->orderByRaw("RAND()")->take(6)->get(); ?>
        <div class="slideshow"> @foreach ($media as $m) @if($m->is_video)
            <div class="slideshow-item" style="background-image: url('{{$m->vid_img}}')">
                <a href="{{url('/')}}/media/{{$m->short_url}}"> </a>
            </div> @else
            <div class="slideshow-item" style="background-image: url('{{$m->pic_url}}')">
                <a href="{{url('/')}}/media/{{$m->short_url}}"> </a>
            </div> @endif @endforeach </div>
        <div class="row" id="search_box" style="width: 100%;margin-bottom: 50px">
            <div class="col-xs-8 col-xs-offset-2">
                <form method="GET" action="{{url('/')}}/search" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" value="{{ old('q') }}" name="q" placeholder="{{Lang::get('home.looking_for')}}"> <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><span class="fa fa-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div> @yield('content')
<script src="{{ url('/') }}/themes/brown/front/bootstrap.min.js"></script> {{--
<script src="{{ elixir('js/app.js') }}"></script> --}}
<script src="{{ url('/') }}/themes/brown/front/jquery.infinitescroll.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
<script src="{{ url('/') }}/themes/brown/front/scripts.js"></script>
</body>
</html>