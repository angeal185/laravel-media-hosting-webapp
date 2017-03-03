<div class="page-sidebar-wrapper">
	<div class="page-sidebar navbar-collapse collapse">
		<ul class="page-sidebar-menu page-sidebar-menu-light page-sidebar-menu-hover-submenu" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
			<li><a href="{{url('dashboard')}}"> <i class="icon-fire"></i> <span class="title">Dashboard</span> </a></li>
			<li><a href="javascript:;"> <i class="icon-settings"></i> <span class="title">Media Settings</span> <span class="arrow "></span> </a>
				<ul class="sub-menu">
					<li><a href="{{url('dashboard/media/picture')}}"> <i class="icon-camera"></i> Add picture</a></li>
					<li><a href="{{url('dashboard/media/video')}}"> <i class="icon-camrecorder"></i> Add video</a></li>
					<li><a href="{{url('dashboard/media')}}"> <i class="icon-settings"></i> Media Settings</a></li>
					<li><a href="{{url('dashboard/media/flagged')}}"> <i class="icon-flag"></i> Flagged Media</a></li>
				</ul>
			</li>
			<li><a href="javascript:;"> <i class="icon-docs"></i> <span class="title">Pages</span> <span class="arrow "></span> </a>
				<ul class="sub-menu">
					<li><a href="{{url('dashboard/pages/new')}}"> <i class="icon-pencil"></i> Add page</a></li>
					<li><a href="{{url('dashboard/pages')}}"> <i class="icon-settings"></i> Pages settings</a></li>
				</ul>
			</li>
			<li>
				<a href="javascript:;"> <i class="icon-briefcase"></i> <span class="title">Categories</span> <span class="arrow "></span> </a>
				<ul class="sub-menu">
					<li><a href="{{url('dashboard/categories/new')}}"> <i class="icon-plus"></i> Add category</a></li>
					<li><a href="{{url('dashboard/categories')}}"> <i class="icon-settings"></i> Categories settings</a></li>
				</ul>
			</li>
			<li><a href="{{url('dashboard/stats')}}"> <i class="icon-speedometer"></i> <span class="title">System stats</span> </a></li>
			<li><a href="{{url('dashboard/users')}}"> <i class="icon-people"></i> <span class="title">Users settings</span> </a></li>
			<li><a href="{{url('dashboard/ads')}}"> <i class="icon-puzzle"></i> <span class="title">ADS settings</span> </a></li>
			<li><a href="{{url('dashboard/comments')}}"> <i class="icon-bubble"></i> <span class="title">Comments settings</span> <span class="arrow "></span> </a>
				<ul class="sub-menu">
					<li><a href="{{url('dashboard/comments/flagged')}}"> <i class="icon-flag"></i> Flagged Comments</a></li>
				</ul>
			</li>
			<li><a id="jq" href="{{url('dashboard/settings')}}"> <i class="icon-globe"></i> <span class="title">Site settings</span> </a></li>
		</ul>
	</div>
</div>