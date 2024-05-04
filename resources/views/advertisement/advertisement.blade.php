@extends('layouts.master')
@section('content')
    @section('style')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
    <!-- checkbox style -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/checkbox-style.css') }}">
    @endsection
    <!-- Page Wrapper -->	
		<div class="page-wrapper">
			
			<!-- Page Content -->
			<div class="content container-fluid">
			
				<!-- Page Header -->
				<div class="page-header">
					<div class="row align-items-center">
						<div class="col">
							<h3 class="page-title">إعلانات</h3>
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم </a></li>
								<li class="breadcrumb-item active">إعلانات</li>
							</ul>
						</div>
						<div class="col-auto float-right ml-auto">
							<a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> إنشاء إعلان</a>
						</div>
					</div>
				</div>
				<!-- /Page Header -->
				<div class="row">
					@foreach($advertisements as $advertisement)
					<div class="col-12 col-md-6 col-lg-4">
						<div class="card">
							<div class="card-body">
								<div class="dropdown dropdown-action profile-action">
									<a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
									<div class="dropdown-menu dropdown-menu-right">
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project{{$advertisement->id}}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
										<a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project{{$advertisement->id}}"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
									</div>
								</div>
								<div class="card-header">
									<h5 class="card-title mb-0">{{$advertisement->title}}</h5>
								</div>
								<div>
									<p style="margin-bottom: 0;">{{ Str::limit($advertisement->description, 50, '...') }}</p>
									<a href="#" data-toggle="modal" data-target="#advertisementModal{{ $advertisement->id }}">قراءة المزيد</a>
								</div>
							</div>
							<img alt="" src="{{asset($advertisement->image)}}" class="card-img-top" style="width: 100%; height: 200px;">
						</div>
					</div>
				
					<!-- more Modal -->
					<div class="modal fade" id="advertisementModal{{$advertisement->id}}" tabindex="-1" role="dialog" aria-labelledby="advertisementModalLabel{{$advertisement->id}}" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="advertisementModalLabel{{$advertisement->id}}">{{$advertisement->title}}</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>{{$advertisement->description}}</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">إغلاق</button>
								</div>
							</div>
						</div>
					</div>
					<!-- more Modal -->
					<!-- Edit Project Modal -->
					<div id="edit_project{{$advertisement->id}}" class="modal custom-modal fade" role="dialog">
						<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">تعديل </h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<!-- Display validation errors here -->
									<div id="errorContainer"></div>
									<form action="{{ route('all/advertisement/update') }}" method="POST" enctype="multipart/form-data"  id="editadvertisementForm">
										@csrf 
										<input type="hidden" class="form-control" id="id" name="id" value="{{ $advertisement->id}}">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>عنوان الإعلان</label>
													<input class="form-control" type="text" id="name" name="name" value="{{$advertisement->title}}">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label class="col-form-label">صورة <span class="text-danger">*</span></label>
													<input class="form-control" id="image" type="file" name="image">
												</div>
											</div>
											<div class="col-sm-12">
												<div class="form-group">
													<label>وصف</label>
													<textarea rows="4" class="form-control summernote" placeholder="أدخل رسالتك هنا" name="description">{{$advertisement->description}}</textarea>
												</div>
											</div>
										</div>
									
										<div class="submit-section">
											<button class="btn btn-primary submit-btn">حفظ</button>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- /Edit Project Modal -->
					<!-- Delete Project Modal -->
					<div class="modal custom-modal fade" id="delete_project{{$advertisement->id}}" role="dialog">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-body">
									<div class="form-header">
										<h3>حفظ</h3>
										<p>هل أنت متأكد أنك تريد الحذف؟</p>
									</div>
									<div class="modal-btn delete-action">
										<form action="{{ url('all/advertisement/delete') }}" method="POST">
											@csrf
											<input type="hidden" name="id"  value="{{$advertisement->id}}">
											<div class="row">
												<div class="col-6">
													<button type="submit" class="btn btn-primary continue-btn submit-btn">حفظ</button>
												</div>
												<div class="col-6">
													<a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">اغلاق</a>
												</div>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /Delete Project Modal -->
					@endforeach
				</div>
				
			</div>
			<!-- /Page Content -->
			
			<!-- Create Project Modal -->
			<div id="create_project" class="modal custom-modal fade" role="dialog">
				<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">إنشاء إعلان</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<!-- Display validation errors here -->
							<div id="errorContainer"></div>
							<form action="{{ route('all/advertisement/save') }}" method="POST" enctype="multipart/form-data"  id="addadvertisementForm">
								@csrf
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<label>عنوان الإعلان</label>
											<input class="form-control" type="text" name="title">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label>صورة </label>
											<div class="">
												<input class="form-control" id="image" type="file" name="image">
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>وصف</label>
											<textarea rows="4" class="form-control summernote" placeholder="أدخل رسالتك هنا"name="description" ></textarea>
										</div>
									</div>			
								</div>
								<div class="submit-section">
									<button class="btn btn-primary submit-btn">حفظ</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
			<!-- /Create Project Modal -->
			
		</div>
	<!-- /Page Wrapper -->
		@section('script')

		{{-- form validation --}}
		<script>
			$(document).ready(function() {
				$('#addadvertisementForm').submit(function(e) {
					e.preventDefault();
					var form = $(this);
					$.ajax({
						url: form.attr('action'),
						type: 'POST',
						data: new FormData(this),
						processData: false,
						contentType: false,
						success: function(response) {
							// If form submission is successful, do something (e.g., show a success message)
							toastr.success('Advertisement added successfully!');
							// Close the modal after 2 seconds (adjust the time as needed)
							$('#create_project').modal('hide');
							// Reload the page after successful submission
							window.location.reload();
						},
						error: function(xhr) {
							// If form submission fails due to validation errors, display errors dynamically
							var errors = xhr.responseJSON.errors;
							var errorList = '';
							$.each(errors, function(key, value) {
								errorList += '<li>' + value + '</li>';
							});
							$('#errorContainer').html('<div class="alert alert-danger">' +
								'<ul>' + errorList + '</ul>' +
								'</div>').show();
						}
					});
				});
			});
		</script>
		
		@endsection
	
	@endsection
		

        
      