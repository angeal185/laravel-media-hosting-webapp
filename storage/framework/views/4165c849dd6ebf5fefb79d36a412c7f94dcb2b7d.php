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
<title><?php echo $__env->yieldContent('title'); ?></title>
<?php if($__env->yieldContent('description')): ?> <?php echo $__env->yieldContent('description'); ?> <?php else: ?>
<meta content='<?php echo e($description); ?>' name='description' /> <?php endif; ?>
<meta content='<?php echo e($keywords); ?>' name='keywords' />
<meta content='global' name='distribution' />
<meta content='6 days' name='revisit' />
<meta content='6 days' name='revisit-after' />
<meta content='document' name='resource-type' />
<meta content='all' name='audience' />
<meta content='all' name='robots' />
<meta content='index, follow' name='robots' />
<meta content='<?php echo e($site_title); ?>' name='author' />
<meta content='en' name='language' />
<?php if(trim($__env->yieldContent('og_meta'))): ?> <?php echo $__env->yieldContent('og_meta'); ?> <?php endif; ?>
<?php if($favicon == "nofavicon.png"): ?>
<link rel="icon" href="<?php echo e(url('/')); ?>/uploads/settings/nofavicon.png"> <?php else: ?>
<link rel="icon" href="<?php echo e($favicon); ?>"> <?php endif; ?>
<?php echo $__env->make('includes.front.css', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
<noscript><meta http-equiv="refresh" content="0; url=./js" /></noscript>
<?php if($adblock == 1): ?> <?php echo $__env->make('includes.front.adblock', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?>
</head>
<body id="app-layout">
    <div id="fb-root"></div>
	<?php echo $__env->make('includes.front.nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    
    <?php $media = DB::table('media')->where('active', 1)->where('user_id', '!=', 0)->orderByRaw("RAND()")->take(6)->get(); ?>
        <div class="slideshow"> <?php foreach($media as $m): ?> <?php if($m->is_video): ?>
            <div class="slideshow-item" style="background-image: url('<?php echo e($m->vid_img); ?>')">
                <a href="<?php echo e(url('/')); ?>/media/<?php echo e($m->short_url); ?>"> </a>
            </div> <?php else: ?>
            <div class="slideshow-item" style="background-image: url('<?php echo e($m->pic_url); ?>')">
                <a href="<?php echo e(url('/')); ?>/media/<?php echo e($m->short_url); ?>"> </a>
            </div> <?php endif; ?> <?php endforeach; ?> </div>
        <div class="row" id="search_box" style="width: 100%;margin-bottom: 50px">
            <div class="col-xs-8 col-xs-offset-2">
                <form method="GET" action="<?php echo e(url('/')); ?>/search" role="search">
                    <div class="input-group">
                        <input type="text" class="form-control" value="<?php echo e(old('q')); ?>" name="q" placeholder="<?php echo e(Lang::get('home.looking_for')); ?>"> <span class="input-group-btn">
        <button class="btn btn-default" type="submit"><span class="fa fa-search"></span></button>
                        </span>
                    </div>
                </form>
            </div>
        </div> <?php echo $__env->yieldContent('content'); ?>
<script src="<?php echo e(url('/')); ?>/themes/brown/front/bootstrap.min.js"></script> <?php /*
<script src="<?php echo e(elixir('js/app.js')); ?>"></script> */ ?>
<script src="<?php echo e(url('/')); ?>/themes/brown/front/jquery.infinitescroll.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.2.8/jquery.form-validator.min.js"></script>
<script src="<?php echo e(url('/')); ?>/themes/brown/front/scripts.js"></script>
</body>
</html>