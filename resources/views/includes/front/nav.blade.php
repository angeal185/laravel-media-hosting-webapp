<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a class="navbar-brand" href="{{ url('/') }}">
      @if ($logo == "nologo.png")
      <img style="height: 45px;" src="{{url('/')}}/uploads/settings/nologo.png">
      @else
      <img style="height: 45px;" src="{{$logo}}">
      @endif
      </a> </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown"> <a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> {{Lang::get('home.categories')}} <span class="caret"></span></a>
                        <ul style="margin-top: 0px;" class="dropdown-menu"> @foreach (App\Category::all() as $category)
                            <li><a href="{{url('/')}}/category/{{$category->name}}">
            {{ $category->name }}</a></li> @endforeach </ul>
                    </li>
                    <li class="dropdown"> <a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-files-o"></i> {{Lang::get('home.pages')}} <span class="caret"></span></a>
                        <ul style="margin-top: 0px;" class="dropdown-menu"> @foreach (App\Page::all() as $page)
                            <li><a href="{{url('/')}}/page/{{$page->page_url}}">{{ $page->title }}</a></li> @endforeach </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right"> @if (Auth::guest())
                    <li><a style="text-transform: uppercase;" href="{{ url('/login') }}">{{Lang::get('home.login')}}</a></li>
                    <li><a style="text-transform: uppercase;" href="{{ url('/register') }}">{{Lang::get('home.register')}}</a></li> @else
                    <ul class="nav navbar-nav navbar-right">
                        <li style="margin-top: -8px" class="dropdown"> 
							<a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							@if(Auth::user()->avatar == "noavatar.jpg")
							<img width="30" height="30" src="{{url('/')}}/uploads/avatars/noavatar.jpg" class="img-circle">
							@else
							<img width="30" height="30" src="{{ Auth::user()->avatar }}" alt="{{Auth::user()->username }} Profile picture" class="img-circle">
							@endif
							<span id="username_hide">{{Auth::user()->username }}</span> 
							<span class="caret"></span>
							</a>
							<ul style="margin-top: -2px;" class="dropdown-menu">
								<li>
									<a href="{{ url('/') }}/user/{{ Auth::user()->username }}"><i class="fa fa-user"></i> {{Lang::get('home.my_profile')}}</a>
								</li>
								<li>
									<a href="{{ url('/') }}/user/{{ Auth::user()->username }}/likes"><i class="fa fa-heart"></i> {{Lang::get('home.my_likes')}}</a>
								</li> @if (Auth::check() && Auth::user()->level === 1 && Auth::user()->id === 1)
								<li>
									<a href="{{ url('/') }}/dashboard"><i class="fa fa-cog"></i> {{Lang::get('home.dashboard')}}</a>
								</li> @endif
								<li role="separator" class="divider"></li>
								<li>
									<a href="{{ url('/logout') }}"><i class="fa fa-power-off"></i> {{Lang::get('home.logout')}}</a>
								</li>
							</ul>
                        </li>
                    </ul> @endif 
				</ul>
                <div class="upload_zone"> <a href="{{ url('/upload') }}" style="border-radius: 4px;margin-top: 5px;float: right;" type="button" class="btn btn-danger"><i class="fa fa-cloud-upload"></i> {{Lang::get('home.upload_btn')}}</a>
                    <?php
      if (!Auth::guest()) {
        $get_notice = DB::table('notifications')->where('user_id', Auth::user()->id)
                    ->where('status', 0)->get();
      }
      ?> @if (!Auth::guest() AND count($get_notice) !== 0) <a style="color: rgb(254, 214, 76);" data-toggle="tooltip" data-placement="bottom" title="{{Lang::get('home.notifications')}}" class="notification" href="{{ url('/notification') }}"><i class="fa fa-bell"></i></a> @endif <a data-toggle="tooltip" data-placement="bottom" title="{{Lang::get('home.random')}}" class="random" href="{{ url('/random') }}"><i class="fa fa-random"></i></a> </div>
            </div>
        </div>
    </nav>