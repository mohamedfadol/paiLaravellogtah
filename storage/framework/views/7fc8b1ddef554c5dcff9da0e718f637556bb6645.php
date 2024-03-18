		<?php $__env->startSection('page-header'); ?>
			<!--Page header-->
			<div class="page-header">
				<div class="page-leftheader">
					<h4 class="page-title mb-0">Hi! Welcome Back <?php echo e(auth()->user()->name); ?></h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="<?php echo e(url('/' . $page='#')); ?>"><i class="fe fe-home ml-2 fs-14 float-right "></i>Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><a href="<?php echo e(url('/' . $page='#')); ?>">Sales Dashboard</a></li>
					</ol>
				</div>
				<div class="page-rightheader">
					<div class="btn btn-list">
						<a href="<?php echo e(route('dashboard.index')); ?>" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Dashboard </a>
						<a href="<?php echo e(route('subscritions.index')); ?>" class="btn btn-danger"><i class="fe fe-printer mr-1"></i> Subscritions </a>
						<a href="<?php echo e(route('packages.index')); ?>" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Packages </a>
					</div>
				</div>
			</div>
			<!--End Page header-->
		<?php $__env->stopSection(); ?>
				<?php $__env->startSection('content'); ?>
				<!-- Row-1 -->
				<div class="row">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total Sales</p>
								<h2 class="mb-1 number-font">$3,257</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-warning">76%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark1"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total User</p>
								<h2 class="mb-1 number-font">1,678</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-info">85%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark2"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1 ">Total Income</p>
								<h2 class="mb-1 number-font">$2,590</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-danger">62%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark3"></div>
						</div>
					</div>
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden dash1-card border-0">
							<div class="card-body">
								<p class=" mb-1">Total Tax</p>
								<h2 class="mb-1 number-font">$1,954</h2>
								<small class="fs-12 text-muted">Compared to Last Month</small>
								<span class="ratio bg-success">53%</span>
								<span class="ratio-text text-muted">Goals Reached</span>
							</div>
							<div id="spark4"></div>
						</div>
					</div>
				</div>
				<!-- End Row-1 -->
				<!--Row-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Top Product Sales Overview</h3>
								<div class="card-options">
									<a href="<?php echo e(url('/' . $page='#')); ?>" class="option-dots" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal fs-20"></i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="<?php echo e(url('/' . $page='#')); ?>">Today</a>
										<a class="dropdown-item" href="<?php echo e(url('/' . $page='#')); ?>">Last Week</a>
										<a class="dropdown-item" href="<?php echo e(url('/' . $page='#')); ?>">Last Month</a>
										<a class="dropdown-item" href="<?php echo e(url('/' . $page='#')); ?>">Last Year</a>
									</div>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
										<thead class="">
											<tr>
												<th><?php echo e(__('business.business_name')); ?></th>
												<th><?php echo e(__('business.start_date')); ?></th>
                                                <th><?php echo e(__('business.ownre_name')); ?></th>	
                                                <th><?php echo e(__('business.email')); ?></th>											<th>Stock</th>
												<th><?php echo e(__('business.address')); ?></th>
												<th><?php echo e(__('business.status')); ?></th>
                                                <th><?php echo e(__('business.current_subcription')); ?></th>
                                                <th><?php echo e(__('business.actions')); ?></th>
											</tr>
										</thead>
										<tbody>
                                            <?php $__empty_1 = true; $__currentLoopData = $businesses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $business): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <tr>
                                                <td><?php echo e($business->name); ?></td>
                                                <td><?php echo e($business->start_date); ?></td>
                                                <td><?php echo e($business->owner->name); ?></td>
                                                <td><?php echo e($business->owner->email); ?></td>
                                                <td><?php echo e($business->getBusinessAddressAttribute()); ?></td>
                                                <td><?php echo e($business->created_at); ?></td>
                                                <td>
                                                    <?php if($business->is_active == 1): ?>
                                                        <span class="bg-success p-1 border"><?php echo e(__('business.active')); ?></span>
                                                    <?php else: ?>
                                                    <span class="bg-danger p-1 border"><?php echo e(__('business.in_active')); ?></span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <?php if($business->subscriptions): ?>
                                                        <?php $__empty_2 = true; $__currentLoopData = $business->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                                        <?php echo e($subscription->paid_via); ?> <br>
                                                            (<?php echo e($subscription->start_date .' - '. $subscription->end_date); ?>)
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                                            
                                                        <?php endif; ?> 
                                                    <?php endif; ?>
                                                    
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary">Edit</button>
                                                    <button type="button" class="btn btn-danger">delete</button>
                                                </td>
											</tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                
                                            <?php endif; ?>
											
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--End row-->

			</div>
		</div>
		<!-- End app-content-->
	</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('js'); ?>

	<!--INTERNAL Peitychart js-->
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/peitychart/jquery.peity.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/peitychart/peitychart.init.js')); ?>"></script>

	<!--INTERNAL Apexchart js-->
	<script src="<?php echo e(URL::asset('public_theme/assets/js/apexcharts.js')); ?>"></script>

	<!--INTERNAL ECharts js-->
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/echarts/echarts.js')); ?>"></script>

	<!--INTERNAL Chart js -->
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/chart/chart.bundle.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/chart/utils.js')); ?>"></script>

	<!-- INTERNAL Select2 js -->
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/select2/select2.full.min.js')); ?>"></script>
	<script src="<?php echo e(URL::asset('public_theme/assets/js/select2.js')); ?>"></script>

	<!--INTERNAL Moment js-->
	<script src="<?php echo e(URL::asset('public_theme/assets/plugins/moment/moment.js')); ?>"></script>

	<!--INTERNAL Index js-->
	<script src="<?php echo e(URL::asset('public_theme/assets/js/index1.js')); ?>"></script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.theme.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\wamp64\www\apiLaravelLogtah\resources\views/dashboard.blade.php ENDPATH**/ ?>