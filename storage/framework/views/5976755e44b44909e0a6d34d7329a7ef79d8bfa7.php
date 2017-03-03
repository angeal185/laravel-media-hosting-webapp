<nav class="navbar navbar-default navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse"> <span class="sr-only">Toggle Navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button> <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
      <?php if($logo == "nologo.png"): ?>
      <img style="height: 45px;" src="<?php echo e(url('/')); ?>/uploads/settings/nologo.png">
      <?php else: ?>
      <img style="height: 45px;" src="<?php echo e($logo); ?>">
      <?php endif; ?>
      </a> </div>
            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="dropdown"> <a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bars"></i> <?php echo e(Lang::get('home.categories')); ?> <span class="caret"></span></a>
                        <ul style="margin-top: 0px;" class="dropdown-menu"> <?php foreach(App\Category::all() as $category): ?>
                            <li><a href="<?php echo e(url('/')); ?>/category/<?php echo e($category->name); ?>">
            <?php echo e($category->name); ?></a></li> <?php endforeach; ?> </ul>
                    </li>
                    <li class="dropdown"> <a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-files-o"></i> <?php echo e(Lang::get('home.pages')); ?> <span class="caret"></span></a>
                        <ul style="margin-top: 0px;" class="dropdown-menu"> <?php foreach(App\Page::all() as $page): ?>
                            <li><a href="<?php echo e(url('/')); ?>/page/<?php echo e($page->page_url); ?>"><?php echo e($page->title); ?></a></li> <?php endforeach; ?> </ul>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right"> <?php if(Auth::guest()): ?>
                    <li><a style="text-transform: uppercase;" href="<?php echo e(url('/login')); ?>"><?php echo e(Lang::get('home.login')); ?></a></li>
                    <li><a style="text-transform: uppercase;" href="<?php echo e(url('/register')); ?>"><?php echo e(Lang::get('home.register')); ?></a></li> <?php else: ?>
                    <ul class="nav navbar-nav navbar-right">
                        <li style="margin-top: -8px" class="dropdown"> 
							<a href="#" style="min-height: 45px" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
							<?php if(Auth::user()->avatar == "noavatar.jpg"): ?>
							<img width="30" height="30" src="<?php echo e(url('/')); ?>/uploads/avatars/noavatar.jpg" class="img-circle">
							<?php else: ?>
							<img width="30" height="30" src="<?php echo e(Auth::user()->avatar); ?>" alt="<?php echo e(Auth::user()->username); ?> Profile picture" class="img-circle">
							<?php endif; ?>
							<span id="username_hide"><?php echo e(Auth::user()->username); ?></span> 
							<span class="caret"></span>
							</a>
							<ul style="margin-top: -2px;" class="dropdown-menu">
								<li>
									<a href="<?php echo e(url('/')); ?>/user/<?php echo e(Auth::user()->username); ?>"><i class="fa fa-user"></i> <?php echo e(Lang::get('home.my_profile')); ?></a>
								</li>
								<li>
									<a href="<?php echo e(url('/')); ?>/user/<?php echo e(Auth::user()->username); ?>/likes"><i class="fa fa-heart"></i> <?php echo e(Lang::get('home.my_likes')); ?></a>
								</li> <?php if(Auth::check() && Auth::user()->level === 1 && Auth::user()->id === 1): ?>
								<li>
									<a href="<?php echo e(url('/')); ?>/dashboard"><i class="fa fa-cog"></i> <?php echo e(Lang::get('home.dashboard')); ?></a>
								</li> <?php endif; ?>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo e(url('/logout')); ?>"><i class="fa fa-power-off"></i> <?php echo e(Lang::get('home.logout')); ?></a>
								</li>
							</ul>
                        </li>
                    </ul> <?php endif; ?> 
				</ul>
                <div class="upload_zone"> <a href="<?php echo e(url('/upload')); ?>" style="border-radius: 4px;margin-top: 5px;float: right;" type="button" class="btn btn-danger"><i class="fa fa-cloud-upload"></i> <?php echo e(Lang::get('home.upload_btn')); ?></a>
                    <?php
      if (!Auth::guest()) {
        $get_notice = DB::table('notifications')->where('user_id', Auth::user()->id)
                    ->where('status', 0)->get();
      }
      ?> <?php if(!Auth::guest() AND count($get_notice) !== 0): ?> <a style="color: rgb(254, 214, 76);" data-toggle="tooltip" data-placement="bottom" title="<?php echo e(Lang::get('home.notifications')); ?>" class="notification" href="<?php echo e(url('/notification')); ?>"><i class="fa fa-bell"></i></a> <?php endif; ?> <a data-toggle="tooltip" data-placement="bottom" title="<?php echo e(Lang::get('home.random')); ?>" class="random" href="<?php echo e(url('/random')); ?>"><i class="fa fa-random"></i></a> </div>
            </div>
        </div>
    </nav>