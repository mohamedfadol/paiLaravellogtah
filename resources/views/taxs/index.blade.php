@extends('layouts.theme.master')
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
                @include('taxs.partials.create')
				<!--Row-->
				<div class="row">
					<div class="col-xl-12 col-lg-12 col-md-12">
						<div class="card">
							<div class="card-header">
								<h3 class="card-title">Top Taxs</h3>
								<div class="card-options">
                                    @can('new_tax')
									<button type="button"  data-target="#CreateTaxModal"
                                        data-toggle="modal" class="btn btn-success">
                                        <i class="fa fa-plus fa-spin mr-2"></i>
                                        Create Tax1
                                    </button>
                                    @endcan
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="get-all-taxs" class="table table-vcenter text-nowrap mb-0 table-striped table-bordered border-top">
										<thead class="">
											<tr>
                                                <th><input type="checkbox" name="main_checkbox"><label></label></th>
                                                <th>#</th>
												<th>{{__('business.tax_name')}}</th>
                                                <th>{{__('business.tax_amount')}}</th>
                                                <th>{{__('business.actions')}}  <button class="btn btn-sm btn-danger d-none"
                                                    id="deleteAllBtn">Delete All</button></th>
											</tr>
										</thead>
										<tbody>
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
    @include('taxs.partials.edit')
@endsection
@section('js')
<script>
    $( document ).ready(function() {

        toastr.options.preventDuplicates = true;
        $.ajaxSetup({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')}
        });

        //start ADD NEW tax
        $('#tax_form').on('submit', function(e){
            var form_data = new FormData($('#tax_form')[0]);
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
                        $('#get-all-taxs').DataTable().ajax.reload(null, false);
                        $('.tax_form_modal').modal('hide');
                            $('.tax_form_modal').find('form')[0].reset();
                        toastr.success(data.msg);
                        }
                }
            });
        });
        //end ADD NEW Tax

        //start GET ALL taxs
        $('#get-all-taxs').DataTable({
            processing:true,
            info:true,
            ajax:"{{ route('get.taxs.list') }}",
            "pageLength":5,
            "aLengthMenu":[[5,10,25,50,-1],[5,10,25,50,"All"]],
            columns:[
                {data:'checkbox', name:'checkbox', orderable:false, searchable:false},
                {data:'DT_RowIndex', name:'DT_RowIndex'},
                {data:'name',name:'tax_name'},
                {data:'amount',name:'tax_amount'},
                {data:'actions', name:'actions', orderable:false, searchable:false},
            ]
        }).on('draw', function(){
                $('input[name="country_checkbox"]').each(function(){this.checked = false;});
                $('input[name="main_checkbox"]').prop('checked', false);
                $('button#deleteAllBtn').addClass('d-none');
            });
        //end GET ALL taxs


        // start Edit tax
        $(document).on('click','#editTaxBtn', function(){
            var tax_id = $(this).data('id');
            // alert(tax_id);
            $('.edit_tax_form_modal').find('form')[0].reset();
            $('.edit_tax_form_modal').find('span.error-text').text('');
            $.post('<?= route("get.tax.details") ?>',{tax_id:tax_id}, function(data){
                //  alert(data.details.tax_name);
                $('.edit_tax_form_modal').find('input[name="txid"]').val(data.details.id);
                $('.edit_tax_form_modal').find('input[name="tax_name"]').val(data.details.name);
                $('.edit_tax_form_modal').find('input[name="tax_amount"]').val(data.details.amount);
                $('.edit_tax_form_modal').modal('show');
            },'json');
        });
        //UPDATE tax DETAILS
        $('#edit_tax_form').on('submit', function(e){
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
                            $('#get-all-taxs').DataTable().ajax.reload(null, false);
                            $('.edit_tax_form_modal').modal('hide');
                            $('.edit_tax_form_modal').find('form')[0].reset();
                            toastr.success(data.msg);
                        }
                }
            });
        });
        // end start edit tax

        //Start DELETE taxs RECORD
        $(document).on('click','#deleteTaxBtn', function(){
                var country_id = $(this).data('id');
                var url = '<?= route("delete.tax") ?>';
                swal.fire({
                        title:'Are You Sure Of Delete ?',
                        html:'You Want to <b>Delete</b> this taxs',
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
                                    $('#get-all-taxs').DataTable().ajax.reload(null, false);
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
               var url = '{{ route("delete.selected.taxs") }}';
               if(checkedCountries.length > 0){
                   swal.fire({
                       title:'Are you sure ?',
                       html:'You want to delete all <b>('+checkedCountries.length+')</b> taxs ?',
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
                                  $('#get-all-taxs').DataTable().ajax.reload(null, true);
                                  toastr.success(data.msg);
                              }else {
                                toastr.error(data.msg);
                            }
                           },'json');
                       }
                   })
               }
           });
           //End DELETE taxs RECORD

    }); //end function
</script>
@endsection
