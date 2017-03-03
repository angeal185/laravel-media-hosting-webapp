<div class="page-header md-shadow-z-1-i navbar navbar-fixed-top">
    <div class="page-header-inner">
        <div class="page-logo">
            <a href="<?php echo e(url('dashboard')); ?>"><?php if($logo == "nologo.png"): ?>
				<img src="<?php echo e(url('/')); ?>/uploads/settings/nologo.png" style="height: 45px;margin: 0;" alt="logo" class="logo-default"/><?php else: ?>
				<img src="<?php echo e($logo); ?>" style="height: 45px;margin: 0;" alt="logo" class="logo-default"/><?php endif; ?>
            </a>
            <div class="menu-toggler sidebar-toggler"></div>
        </div>
        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"></a>
        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
				<?php
					$count_media = App\Media::where('active', 0)->count();
					$count_comments = App\Comment::where('status', 0)->count();
					$count_flagged_comments = DB::table('comments_flags')->count();
					$count_flagged_media = DB::table('media_flags')->count();
					$all_count = $count_media + $count_comments + $count_flagged_comments + $count_flagged_media;
				?>
                <li class="dropdown dropdown-extended dropdown-notification" id="header_notification_bar">
                    <a href="<?php echo e(url('dashboard/notifications')); ?>" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <i class="icon-bell"></i> <?php if($all_count > 0): ?><span class="badge badge-default"><?php echo e($all_count); ?></span> <?php endif; ?> 
                    </a>
                    <ul class="dropdown-menu">
                        <li class="external">
                            <h3><span class="bold"><?php echo e($all_count); ?> pending</span> notifications</h3>
                        </li>
                        <li>
                            <div style="position: relative; overflow: hidden; width: auto; height: 250px;" class="slimScrollDiv">
                                <ul data-initialized="1" class="dropdown-menu-list scroller" style="height: 250px; overflow: hidden; width: auto;" data-handle-color="#637283">
                                    <li>
                                        <a href="<?php echo e(url('/dashboard/media')); ?>">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-success">
                                                    <i class="fa fa-picture-o"></i>
                                                </span> <?php echo e($count_media); ?> Media waiting for Approval. 
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('/dashboard/comments')); ?>">
                                            <span class="details">
                                                <span style="background-color: #2EAFD2;" class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-comment-o"></i>
                                                </span> <?php echo e($count_comments); ?> Comments waiting for Approval. 
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('/dashboard/comments/flagged')); ?>">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-flag"></i>
                                                </span> <?php echo e($count_flagged_comments); ?> Comments Flagged. 
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?php echo e(url('/dashboard/media/flagged')); ?>">
                                            <span class="details">
                                                <span class="label label-sm label-icon label-danger">
                                                    <i class="fa fa-flag"></i>
                                                </span> <?php echo e($count_flagged_media); ?> Media Flagged. 
                                            </span>
                                        </a>
                                    </li>
                                </ul>
							</div>
                        </li>
                    </ul>
				</li>
				<li class="dropdown dropdown-user">
					<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
						<?php if(Auth::user()->avatar == "noavatar.jpg"): ?> 
						<img alt="" class="img-circle" src="<?php echo e(url('/')); ?>/uploads/avatars/noavatar.jpg" /> <?php else: ?> 
						<img alt="" class="img-circle" src="<?php echo e(Auth::user()->avatar); ?>" /> <?php endif; ?> 
						<span class="username username-hide-on-mobile">
<?php echo e(Auth::user()->username); ?> </span>
						<i class="fa fa-angle-down"></i>
					</a>
					<ul class="dropdown-menu dropdown-menu-default">
						<li>
							<a href="<?php echo e(url('dashboard/profile')); ?>">
								<i class="icon-user"></i> My Profile 
							</a>
						</li>
						<li>
							<a href="<?php echo e(url('/')); ?>" target="_blank">
								<i class="icon-eye"></i> View Site 
							</a>
						</li>
						<li class="divider"></li>
						<li>
							<a href="<?php echo e(url('dashboard/logout')); ?>">
								<i class="icon-power"></i> Log Out 
							</a>
						</li>
					</ul>
				</li>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
</div>