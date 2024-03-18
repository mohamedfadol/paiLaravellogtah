@extends('layouts.theme.master')
@section('css')
		<!-- Slect2 css -->
		<link href="{{URL::asset('public_theme/assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
@endsection
		@section('page-header')
			<!--Page header-->
			<div class="page-header">
				<div class="page-leftheader">
					<h4 class="page-title mb-0">Hi! Welcome Back {{ auth()->user()->name}}</h4>
					<ol class="breadcrumb">
						<li class="breadcrumb-item"><a href="{{url('/' . $page='#')}}"><i class="fe fe-home ml-2 fs-14 float-right "></i>Home</a></li>
						<li class="breadcrumb-item active" aria-current="page"><a href="{{url('/' . $page='#')}}">Sales Dashboard</a></li>
					</ol>
				</div>
				<div class="page-rightheader">
					<div class="btn btn-list">
						<a href="{{route('dashboard.index')}}" class="btn btn-info"><i class="fe fe-settings mr-1"></i> Dashboard </a>
						<a href="{{route('subscritions.index')}}" class="btn btn-danger"><i class="fe fe-printer mr-1"></i> Subscritions </a>
						<a href="{{route('packages.index')}}" class="btn btn-warning"><i class="fe fe-shopping-cart mr-1"></i> Ppackages </a>
					</div>
				</div>
			</div>
			<!--End Page header-->
		@endsection
				@section('content')
                @include('packages.partials.create')
				<!--Row-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
                            {{-- start session success for any insert success --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li class="alert alert-danger alert-block text-center">{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            {{-- end session success for any insert success --}}
							<div class="card-header">
								<h3 class="card-title">Top Packages</h3>
								<div class="card-options">
                                    <button type="button"  data-target="#CreatePackageModal"
                                        data-toggle="modal" class="btn btn-success">
                                        <i class="fa fa-plus fa-spin mr-2"></i>
                                        Create Package
                                    </button>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="get-all-packages" class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
										<thead class="">
											<tr>
                                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                                <th>#</th>
                                                <th>{{__('business.package_name')}}</th>
                                                <th>{{__('business.package_price')}}</th>
												<th>{{__('business.package_description')}}</th>
                                                <th>{{__('business.actions')}}  <button class="btn btn-sm btn-danger d-none" id="deleteAllBtn">Delete All</button></th>
											</tr>
										</thead>
										<tbody></tbody>
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
    @include('packages.partials.edit')
@endsection
@section('js')

<script>
    $( document ).ready(function() {

        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}
        });

        //start ADD NEW Package
        $('#package_form').on('submit', function(e){
            var form_data = new FormData($('#package_form')[0]);
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:form_data,
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(){
                        $(form).find('span.error-text').text('');
                },
                success:function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $(form)[0].reset();
                        //  alert(data.msg);
                        $('#get-all-packages').DataTable().ajax.reload(null, false);
                        $('.package_form_modal').modal('hide');
                            $('.package_form_modal').find('form')[0].reset();
                        toastr.success(data.msg);
                        }
                }
            });
        });
        //end ADD NEW package


        //start GET ALL packages
        $('#get-all-packages').DataTable({
            processing:true,
            info:true,
            ajax:"{{ route('get.packages.list') }}",
            "pageLength":5,
            "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
            columns:[
                {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'name',name:'package_name'},
                {data:'price',name:'package_price'},
                {data:'description',name:'package_description'},
                {data:'actions', name:'actions', orderable:false, searchable:false},
            ]
        }).on('draw', function(){
                $('input[name="country_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
        //end GET ALL packages


        // start Edit package
        $(document).on('click','#editPackageBtn', function(){
            var package_id = $(this).data('id');
            // alert(package_id);
            $('.edit_package_form_modal').find('form')[0].reset();
            $('.edit_package_form_modal').find('span.error-text').text('');
            $.post('<?= route("get.package.details") ?>',{package_id:package_id}, function(data){
                //  alert(data.details.package_name);
                $('.edit_package_form_modal').find('input[name="pid"]').val(data.details.id);
                $('.edit_package_form_modal').find('input[name="package_name"]').val(data.details.name);
                $('.edit_package_form_modal').find('input[name="description"]').val(data.details.description);
                $('.edit_package_form_modal').find('input[name="price"]').val(data.details.price);
                $('.edit_package_form_modal').find('input[name="package_trial_days"]').val(data.details.trial_days);
                $('.edit_package_form_modal').find("#interval option:selected").val(data.details.interval);
                $('.edit_package_form_modal').modal('show');
            },'json');
        });
        //UPDATE package DETAILS
        $('#edit_package_form').on('submit', function(e){
            e.preventDefault();
            var form = this;
            $.ajax({
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend: function(){
                        $(form).find('span.error-text').text('');
                },
                success: function(data){
                        if(data.code == 0){
                            $.each(data.error, function(prefix, val){
                                $(form).find('span.'+prefix+'_error').text(val[0]);
                            });
                        }else{
                            $('#get-all-packages').DataTable().ajax.reload(null, false);
                            $('.edit_package_form_modal').modal('hide');
                            $('.edit_package_form_modal').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                }
            });
        });
        // end start edit package

        //Start DELETE packages RECORD
        $(document).on('click','#deletePackageBtn', function(){
                var country_id = $(this).data('id');
                var url = '<?= route("delete.package") ?>';
                swal.fire({
                        title:'Are You Sure Of Delete ?',
                        html:'You Want to <b>Delete</b> this Packages',
                        showCancelButton:true,
                        showCloseButton:true,
                        cancelButtonText:'Cancel',
                        confirmButtonText:'Yes, Delete',
                        cancelButtonColor:'#d33',
                        confirmButtonColor:'#556ee6',
                        width:400,
                        allowOutsideClick:false
                }).then(function(result){
                        if(result.value){
                            $.post(url,{country_id:country_id}, function(data){
                                if(data.code == 1){
                                    $('#get-all-packages').DataTable().ajax.reload(null, false);
                                    toastr.success(data.msg);
                                }else{
                                    toastr.error(data.msg);
                                }
                            },'json');
                        }
                });
            });


        $(document).on('click','input[name="main_checkbox"]', function(){
                  if(this.checked){
                    $('input[name="country_checkbox"]').each(function(){
                        this.checked = true;
                    });
                  }else{
                     $('input[name="country_checkbox"]').each(function(){
                         this.checked = false;
                     });
                  }
                  toggledeleteAllBtn();
           });
           $(document).on('change','input[name="country_checkbox"]', function(){
               if( $('input[name="country_checkbox"]').length == $('input[name="country_checkbox"]:checked').length ){
                   $('input[name="main_checkbox"]').prop('checked', true);
               }else{
                   $('input[name="main_checkbox"]').prop('checked', false);
               }
               toggledeleteAllBtn();
           });
           function toggledeleteAllBtn(){
               if( $('input[name="country_checkbox"]:checked').length > 0 ){
                   $('button#deleteAllBtn').text('Delete ('+$('input[name="country_checkbox"]:checked').length+')').removeClass('d-none');
               }else{
                   $('button#deleteAllBtn').addClass('d-none');
               }
           }


           $(document).on('click','button#deleteAllBtn', function(){
               var checkedCountries = [];
               $('input[name="country_checkbox"]:checked').each(function(){
                   checkedCountries.push($(this).data('id'));
               });
               var url = '{{ route("delete.selected.packages") }}';
               if(checkedCountries.length > 0){
                   swal.fire({
                       title:'Are you sure ?',
                       html:'You want to delete all <b>('+checkedCountries.length+')</b> packages ?',
                       showCancelButton:true,
                       showCloseButton:true,
                       confirmButtonText:'Yes, Delete',
                       cancelButtonText:'Cancel',
                       confirmButtonColor:'#556ee6',
                       cancelButtonColor:'#d33',
                       width:400,
                       allowOutsideClick:false
                   }).then(function(result){
                       if(result.value){
                           $.post(url,{countries_ids:checkedCountries},function(data){
                              if(data.code == 1){
                                  $('#get-all-packages').DataTable().ajax.reload(null, true);
                                  toastr.success(data.msg);
                              }
                           },'json');
                       }
                   })
               }
           });
           //End DELETE packages RECORD

    }); //end function
</script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('public_theme/assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{URL::asset('public_theme/assets/js/select2.js')}}"></script>
{{-- <script>
    /* function for delete User with alert modal */
    $("#DelePackageModal").on('show.bs.modal.delete', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var modal = $(this);
        modal.find('.modal-body #id').val(id);
    });
</script> --}}
@endsection
