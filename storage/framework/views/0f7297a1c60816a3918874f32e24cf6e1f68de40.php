<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <div class="page-content">
        <h3 class="page-title">Dashboard</h3>
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <i class="fa fa-home"></i> <a href="<?php echo e(url('dashboard')); ?>">Home</a> <i class="fa fa-angle-right"></i> </li>
                <li> <a href="<?php echo e(url('dashboard')); ?>">Dashboard</a> </li>
            </ul>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat blue-madison">
                    <div class="visual"> <i class="fa fa-camera"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($total_pic); ?> </div>
                        <div class="desc"> Images </div>
                    </div> 
					<a class="more" href="<?php echo e(url('/dashboard/media')); ?>">View more <i class="m-icon-swapright m-icon-white"></i></a> 
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div style="background-color: #e3af34;" class="dashboard-stat purple-plum">
                    <div class="visual"> <i class="fa fa-video-camera"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($total_vid); ?> </div>
                        <div class="desc"> Media </div>
                    </div> 
					<a style="background-color: #d79e18;" class="more" href="<?php echo e(url('/dashboard/media')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a> 
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat red-intense">
                    <div class="visual"> <i class="fa fa-users"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($total_user); ?> </div>
                        <div class="desc"> Users </div>
                    </div> 
					<a class="more" href="<?php echo e(url('/dashboard/users')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a> 
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat green-haze">
                    <div class="visual"> <i class="fa fa-eye"></i> </div>
                    <div class="details">
                        <div class="number">
                            <?php $count_views = DB::table('media_views')->count(); ?> <?php echo e($count_views); ?> 
						</div>
                        <div class="desc"> Views </div>
                    </div> 
					<a class="more" href="<?php echo e(url('/dashboard/media')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div class="dashboard-stat purple-plum">
                    <div class="visual"> <i class="fa fa-comments"></i> </div>
                    <div class="details">
                        <div class="number">
                            <?php $total_comments = DB::table('comments')->count(); ?> <?php echo e($total_comments); ?> 
						</div>
                        <div class="desc"> Comments </div>
                    </div> 
					<a class="more" href="<?php echo e(url('/dashboard/comments')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div style="background-color: #3D5A98;" class="dashboard-stat purple-plum">
                    <div class="visual"> <i class="fa fa-facebook"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($fb_users); ?> </div>
                        <div class="desc"> Facebook users </div>
                    </div> 
					<a style="background-color: #23438a;" class="more" href="<?php echo e(url('/dashboard/users')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div style="background-color: rgb(32, 184, 255);" class="dashboard-stat purple-plum">
                    <div class="visual"> <i style="color: #011924;" class="fa fa-twitter"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($tw_users); ?> </div>
                        <div class="desc"> Twitter users </div>
                    </div>
					<a style="background-color: #1093d1;" class="more" href="<?php echo e(url('/dashboard/users')); ?>"> View more <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <div style="background-color: #DD4C3B;" class="dashboard-stat purple-plum">
                    <div class="visual"> <i class="fa fa-google"></i> </div>
                    <div class="details">
                        <div class="number"> <?php echo e($go_users); ?> </div>
                        <div class="desc"> Google+ users </div>
                    </div>
					<a style="background-color: #c03726;" class="more" href="<?php echo e(url('/dashboard/users')); ?>">View more <i class="m-icon-swapright m-icon-white"></i></a>
				</div>
            </div>
        </div>
		<a href="javascript:;" class="page-quick-sidebar-toggler"><i class="icon-close"></i></a>
	</div>
</div><?php $__env->stopSection(); ?>


<?php echo $__env->make('admin.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>