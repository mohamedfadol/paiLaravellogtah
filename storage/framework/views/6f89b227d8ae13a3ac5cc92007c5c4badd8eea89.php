<!DOCTYPE html>
<html lang="en" dir="rtl">
	<head>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Admitro - Admin Panel HTML template" name="description">
		<meta content="Spruko Technologies Private Limited" name="author">
		<meta name="keywords" content="admin panel ui, user dashboard template, web application templates, premium admin templates, html css admin templates, premium admin templates, best admin template bootstrap 4, dark admin template, bootstrap 4 template admin, responsive admin template, bootstrap panel template, bootstrap simple dashboard, html web app template, bootstrap report template, modern admin template, nice admin template"/>
		<?php echo $__env->make('layouts.theme.head', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

		</head>

		<body class="app sidebar-mini "> 
	<div id="global-loader" >
		<img src="<?php echo e(URL::asset('public_theme/assets/images/svgs/loader.svg')); ?>" alt="loader">
	</div>
	<!--- End Global-loader-->

	<!-- Page -->
	<div class="page">
		<div class="page-main">
				<?php echo $__env->make('layouts.theme.aside-menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				<!-- App-Content -->
				<div class="app-content main-content">
					<div class="side-app">
						<?php echo $__env->make('layouts.theme.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
						<?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('superadmin')): ?>
							<?php echo $__env->yieldContent('page-header'); ?>
						<?php endif; ?>
						<?php echo $__env->yieldContent('content'); ?>
						<?php echo $__env->make('layouts.theme.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
		</div><!-- End Page -->
			<?php echo $__env->make('layouts.theme.footer-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	</body>
</html>
<?php /**PATH C:\xampp\htdocs\apiLaravelLogtah\resources\views/layouts/theme/master.blade.php ENDPATH**/ ?>