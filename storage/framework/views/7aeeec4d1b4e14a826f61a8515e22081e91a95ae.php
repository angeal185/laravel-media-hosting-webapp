<?php $__env->startSection('title'); ?> <?php echo e($setting->website_name); ?> | <?php echo e($setting->title_description); ?> <?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-8 home-content">
            <?php if($ads->home_top_ad_code): ?>
            <div class="top_ad" id="adblock"> <?php echo $ads->home_top_ad_code; ?> </div> <?php elseif(!$ads->home_top_ad_code AND $ads->home_top_ad_img): ?>
            <div class="top_ad" id="adblock"> <img style="width: 100%" src="<?php echo e($ads->home_top_ad_img); ?>"> </div> <?php endif; ?>
            <center>
                <div class="row" style="margin-bottom: 50px">
                    <div id="boxes">
                        <?php if( count($media) !== 0): ?> <?php foreach($media as $m): ?>
                        <div class="box col-lg-4 col-sm-6 col-xs-12 pomy_box">
                            <div class="pomy_media_box"> <?php if($m->is_video == 1): ?> <a href="#" class="is_vid_img"><i class="fa fa-video-camera"></i> <?php echo e(Lang::get('home.is_video')); ?></a> <?php else: ?> <a href="#" class="is_vid_img"><i class="fa fa-camera"></i> <?php echo e(Lang::get('home.is_image')); ?></a> <?php endif; ?>
                                <div class="pomy_image"> <a href="<?php echo e(url('/')); ?>/media/<?php echo e($m->short_url); ?>">
						<?php if($m->is_video == 1): ?>
						<img src="<?php echo e($m->vid_img); ?>" class="pomy_img img-responsive">
						<?php else: ?>
						<img src="<?php echo e($m->pic_url); ?>" class="pomy_img img-responsive">
						<?php endif; ?>
						</a> </div>
                                <div class="pomy_title">
                                    <h3><?php echo e($m->title); ?></h3> </div>
                                <div class="pomy_stats">
                                    <?php
							$get_comments = DB::table('comments')->where('media_id', $m->id)->where('status', 1)->count();
						?> <span style="color: rgb(212, 163, 48);">
						<?php echo e($get_comments); ?> </span> <span> <?php echo e(Lang::get('home.comments')); ?> </span>
                                        <?php
							$count_views = DB::table('media_views')->where('media_id', $m->id)->count();
							if ($count_views >= 1000) {
								$change_num_format = App\libraries\Helper::thousandsNumberFormat($count_views);
							}else{
								$change_num_format = $count_views;
							}
						?> <span style="color: rgb(212, 163, 48);"><?php echo e($change_num_format); ?></span> <span> <?php echo e(Lang::get('home.views')); ?> </span>
                                            <?php
							$get_votes = DB::table('media_likes')->where('media_id', $m->id)->count();
						?> <span style="color: rgb(212, 163, 48);">
						<?php echo e($get_votes); ?> </span> <span> <?php echo e(Lang::get('home.votes')); ?></span> </div>
                            </div>
                        </div>
                        <?php endforeach; ?> <?php else: ?>
                        <div class="no-media" role="alert"> <b>Heads up!</b> No media right now. Please try again later. </div> <?php endif; ?> </div>
                    <div class="col-span-12">
                        <div style="display: none;" class="paginate text-center"> <?php echo e($media->links()); ?> </div>
                    </div>
                </div>
            </center>
        </div>
        <div class="col-xs-6 col-md-4 sidebar">
            <div class="sidebar_box">
                <button style="color: #dbdbdb;box-shadow:none;background-color: #1D1C1C;" onclick="window.location.href='<?php echo e(url('/')); ?>/upload'" type="button" class="btn btn-primary btn-lg btn-block"><i class="fa fa-cloud-upload"></i> <?php echo e(Lang::get('home.submit_media')); ?></button>
            </div>
            <?php if($ads->home_side_ad_code): ?>
            <div class="sidebar_box" style="padding: 9px"> <?php echo $ads->home_side_ad_code; ?> </div> <?php elseif(!$ads->home_side_ad_code AND $ads->home_side_ad_img): ?>
            <div class="sidebar_box" style="padding: 9px"> <img src="<?php echo e($ads->home_side_ad_img); ?>" class="img-responsive" alt="Responsive image"> </div> <?php endif; ?>
            <div class="tagline"> <span><?php echo e(Lang::get('home.follow_us')); ?></span> </div>
            <div class="social_icons">
                <ul style="margin-right: 35px" class="social-links clearfix">
                    <?php if($setting->facebook_page_id): ?>
                    <li data-toggle="tooltip" data-placement="bottom" title="On Facebook" class="facebook">
                        <a href="<?php echo e($setting->facebook_page_id); ?>" target="_blank"> <i class="fa fa-facebook"></i> </a>
                    </li> <?php endif; ?>
                    <?php if($setting->twitter_page_id): ?>
                    <li data-toggle="tooltip" data-placement="bottom" title="On Twitter" class="twitter">
                        <a href="<?php echo e($setting->twitter_page_id); ?>" target="_blank"> <i class="fa fa-twitter"></i> </a>
                    </li> <?php endif; ?>
                    <?php if($setting->google_page_id): ?>
                    <li data-toggle="tooltip" data-placement="bottom" title="On Google+" class="google">
                        <a href="<?php echo e($setting->google_page_id); ?>" target="_blank"> <i class="fa fa-google-plus"></i> </a>
                    </li> <?php endif; ?> </ul>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>