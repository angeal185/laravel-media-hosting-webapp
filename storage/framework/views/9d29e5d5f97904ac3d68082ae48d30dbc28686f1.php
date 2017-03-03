<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta charset="utf-8" />
<?php
$get_settings = DB::table('settings')->where('id', 1)->first();
$favicon = $get_settings->favicon;
$logo    = $get_settings->logo;
$title   = $get_settings->website_name;
?>
<title><?php echo e($title); ?> | Dashboard</title>
<meta name="robots" content="noindex">
<?php if($favicon == "nofavicon.png"): ?>
<link rel="icon" href="<?php echo e(url('/')); ?>/uploads/settings/nofavicon.png"> <?php else: ?>
<link rel="icon" href="<?php echo e($favicon); ?>"> <?php endif; ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<?php echo $__env->make('includes.back.head', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</head>
<body class="page-md page-header-fixed page-quick-sidebar-over-content">
<div class="page-container">
<?php echo $__env->make('includes.back.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php echo $__env->make('includes.back.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('includes.back.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>
<?php echo $__env->make('includes.back.scripts', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</body>
</html>