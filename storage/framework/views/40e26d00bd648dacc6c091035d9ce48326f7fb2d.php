
<?php $__env->startSection('css'); ?>
        <!-- INTERNAL File Uploads css -->
        <link href="<?php echo e(URL::asset('public_theme/assets/plugins/fancyuploder/fancy_fileupload.css')); ?>" rel="stylesheet" />
        <!-- INTERNAL File Uploads css-->
        <link href="<?php echo e(URL::asset('public_theme/assets/plugins/fileupload/css/fileupload.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- INTERNAL Prism Css -->
		<link href="<?php echo e(URL::asset('public_theme/assets/plugins/prism/prism.css')); ?>" rel="stylesheet">
		<!-- Slect2 css -->
		<link href="<?php echo e(URL::asset('public_theme/assets/plugins/select2/select2.min.css')); ?>" rel="stylesheet" />
		<!-- INTERNAl Forn-wizard css-->
		<link href="<?php echo e(URL::asset('public_theme/assets/plugins/forn-wizard/css/forn-wizard.css')); ?>" rel="stylesheet" />
		<link href="<?php echo e(URL::asset('public_theme/assets/plugins/formwizard/smart_wizard.css')); ?>" rel="stylesheet">
		<link href="<?php echo e(URL::asset('public_theme/assets/plugins/formwizard/smart_wizard_theme_dots-rtl.css')); ?>" rel="stylesheet">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?> 
<div class="page">
			<div class="page-single">
				<div class="p-5">
					<div class="row">
						<div class="col mx-auto">
							<div class="row justify-content-center">
								<div class="col-md-12">
									<div class="card-group mb-0">
										<div class="card p-4">
											<div class="card-body">
												<div class="text-center title-style mb-6">
												    
												    <?php if($errors->any()): ?>
                                                        <div class="alert alert-danger">
                                                            <ul>
                                                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <li><?php echo e($error); ?></li>
                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                            </ul>
                                                        </div>
                                                    <?php endif; ?>
    												<h1 class="mb-2">Register</h1>
    												<hr>
    												<p class="text-muted">Create New Account</p>
    											</div>
											<div class="btn-list d-flex">
												<a href="https://www.google.com/gmail/" class="btn btn-google btn-block"><i class="fa fa-google fa-1x mr-2"></i> Google</a>
												<a href="https://twitter.com/" class="btn btn-twitter"><i class="fa fa-twitter fa-1x"></i></a>
												<a href="https://www.facebook.com/" class="btn btn-facebook"><i class="fa fa-facebook fa-1x"></i></a>
											</div>
											<hr class="divider my-6">
                                        
                                            

                                            <?php echo $__env->make('business.partials.register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                    
                                                 

                                            
											<div class="text-center pt-4">
												<div class="font-weight-normal fs-16">You Already have an account 
                                                    <a class="btn-link font-weight-normal" href="<?php echo e(route('login')); ?>">Login Here</a></div>
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

		<!-- INTERNAl Jquery.steps js -->
		<script src="<?php echo e(URL::asset('public_theme/assets/plugins/jquery-steps/jquery.steps.min.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('public_theme/assets/plugins/parsleyjs/parsley.min.js')); ?>"></script>

		<!-- INTERNAl Forn-wizard js-->
		<script src="<?php echo e(URL::asset('public_theme/assets/plugins/formwizard/jquery.smartWizard.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('public_theme/assets/plugins/formwizard/fromwizard.js')); ?>"></script>

		<!-- INTERNAl Accordion-Wizard-Form js-->
		<script src="<?php echo e(URL::asset('public_theme/assets/plugins/accordion-Wizard-Form/jquery.accordion-wizard.min.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('public_theme/assets/js/form-wizard-rtl.js')); ?>"></script>
		<script src="<?php echo e(URL::asset('public_theme/assets/js/form-wizard2.js')); ?>"></script>
		
		    <!-- INTERNAL Clipboard js -->
        <script src="<?php echo e(URL::asset('public_theme/assets/plugins/clipboard/clipboard.min.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public_theme/assets/plugins/clipboard/clipboard.js')); ?>"></script>
    
        <!-- INTERNAL Prism js -->
        <script src="<?php echo e(URL::asset('public_theme/assets/plugins/prism/prism.js')); ?>"></script>
        <!-- INTERNAL Select2 js -->
        <script src="<?php echo e(URL::asset('public_theme/assets/plugins/select2/select2.full.min.js')); ?>"></script>


		    <!-- INTERNAL File uploads js -->
        <script src="<?php echo e(URL::asset('public_theme/assets/plugins/fileupload/js/dropify.js')); ?>"></script>
        <script src="<?php echo e(URL::asset('public_theme/assets/js/filupload.js')); ?>"></script>
    
        <!--INTERNAL Form Advanced Element -->
        <script src="<?php echo e(URL::asset('public_theme/assets/js/file-upload.js')); ?>"></script>

        
<?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.theme.master3', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\apiLaravelLogtah\resources\views/business/register.blade.php ENDPATH**/ ?>