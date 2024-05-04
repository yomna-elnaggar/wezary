
@extends('layouts.master')
@section('content')	
			
	<!-- Page Wrapper -->
	<div class="page-wrapper">
	
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row">
					<div class="col-sm-12">
						<h3 class="page-title">حول وزاري</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم </a></li>
							<li class="breadcrumb-item active">حول وزاري</li>
						</ul>
					</div>
				</div>
			</div>
			<!-- /Page Header -->
			
			<div class="faq-card">
				@foreach($abouts as $about)
				<div class="card">
					<div class="card-header">
						<h4 class="card-title">
							<a class="collapsed" data-toggle="collapse" href="#collapseOne{{$about->id}}">{{$about->name}}</a>
						</h4>
					</div>
					<div id="collapseOne{{$about->id}}" class="card-collapse collapse">
						<div class="card-body">
							<p>{{$about->description}}</p>
							<a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_about{{$about->id}}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
						</div>
					</div>
				</div>
				<!-- Edit about Modal -->
                <div id="edit_about{{$about->id}}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">تعديل </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                            
                                <form action="{{ route('all/AboutWezary/update', 'updateRecord') }}" method="POST" enctype="multipart/form-data"  id="editCourseForm">
                                    @csrf 
                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $about->id}}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label> الاسم</label>
                                                <input class="form-control" type="text" id="name" name="name" value="{{$about->name}}">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>الوصف</label>
                                                <textarea rows="6" class="form-control summernote" placeholder="Enter your message here" name="description">{{$about->description}}</textarea>
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
				@endforeach
			</div>
			
		</div>
		<!-- /Page Content -->
		
	</div>
	<!-- /Page Wrapper -->
@endsection