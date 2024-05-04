@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">الملف الشخصي</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الملف الشخصي</li>
                        </ul>
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <!-- /Page Header -->
            <div class="card mb-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="profile-view">
                                <div class="profile-img-wrap">
                                    <div class="profile-img">
                                        <a href="#"><img alt="" src="{{ $admin->image}}" alt="{{ $admin->name }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $admin->name }}</h3>
                                                <h6 class="text-muted"> {{ $admin->department }}</h6>
                                                <small class="text-muted">{{ $admin->description }}</small>
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">الهاتف:</div>
                                                    <div class="text">
                                                        @if(!empty($admin->phone_number))
                                                            <a>{{ $admin->phone_number }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">البريد الإلكتروني:</div>
                                                    <div class="text">
                                                        @if(!empty($admin->email))
                                                        <a>{{ $admin->email }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">تاريخ الانضمام:</div>
                                                    <div class="text">
                                                        @if(!empty($admin->join_date))
                                                        <a>{{ $admin->join_date }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">القسم:</div>
                                                    <div class="text">
                                                        @if(!empty($admin->department))
                                                        <a>{{ $admin->department }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">الجنس:</div>
                                                    <div class="text">
                                                        @if(!empty($admin->gender))
                                                        <a>{{ $admin->gender }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="pro-edit"><a data-target="#profile_info" data-toggle="modal" class="edit-icon" href="#"><i class="fa fa-pencil"></i></a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
        <!-- /Page Content -->

        <!-- Profile Modal -->
        <div id="profile_info" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">معلومات الملف الشخصي</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('profile/information/save') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap edit-img">
                                        <img class="inline-block" src="{{ URL::to( $admin->image) }}" alt="{{ $admin->name }}">
                                        <div class="fileupload btn">
                                            <span class="btn-text">تعديل</span>
                                            <input class="upload" type="file" id="image" name="image">
                                            @if(!empty($admin))
                                            <input type="hidden" name="hidden_image" id="e_image" value="{{ $admin->image }}">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>الاسم كامل</label>
                                                <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}">
                                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $admin->id }}">
                                                <input type="hidden" class="form-control" id="email" name="email" value="{{ $admin->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>البريد الإلكتروني </label>
                                                <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>الهاتف</label>
                                                    @if(!empty($admin))
                                                        <input class="form-control " type="text" id="phone_number" name="phone_number" value="{{ $admin->phone_number }}">
                                                    @else
                                                        <input class="form-control " type="text" id="phone_number" name="phone_number">
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>الجنس</label>
                                                <select class="select form-control" id="gender" name="gender">
                                                    @if(!empty($admin))
                                                        <option value="{{ $admin->gender }}" {{ ( $admin->gender == $admin->gender) ? 'selected' : '' }}>{{ $admin->gender }} </option>
                                                        <option value="Male">ذكر</option>
                                                        <option value="Female">انثى</option>
                                                    @else
                                                        <option value="Male">ذكر</option>
                                                        <option value="Female">انثى</option>
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>القسم </label>
                                            <input type="text" class="form-control" id="department" name="department" value="{{ $admin->department }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الوصف <span class="text-danger">*</span></label>
                                            @if(!empty($admin))
                                            <textarea rows="2" class="form-control" id="description" name="description">{{ $admin->description }}</textarea>
                                            @else
                                            <textarea rows="2" class="form-control" id="description" name="description">{{ $admin->description }}</textarea>
                                            @endif
                                    </div>
                                </div>  
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Profile Modal -->

        <!-- Personal Info Modal -->
				<div id="personal_info_modal" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title">معلومات شخصية</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>Passport No</label>
												<input type="text" class="form-control">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Passport Expiry Date</label>
												<div class="cal-icon">
													<input class="form-control datetimepicker" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Tel</label>
												<input class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Nationality <span class="text-danger">*</span></label>
												<input class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Religion</label>
												<div class="cal-icon">
													<input class="form-control" type="text">
												</div>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Marital status <span class="text-danger">*</span></label>
												<select class="select form-control">
													<option>-</option>
													<option>Single</option>
													<option>Married</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>Employment of spouse</label>
												<input class="form-control" type="text">
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>No. of children </label>
												<input class="form-control" type="text">
											</div>
										</div>
									</div>
									<div class="submit-section">
										<button class="btn btn-primary submit-btn">Submit</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- /Personal Info Modal -->
    
       
    <!-- /Page Content -->
    </div>
    @section('script')
    <script>
        $('#validation').validate({  
            rules: {  
                name_primary: 'required',  
                relationship_primary: 'required',  
                phone_primary: 'required',  
                phone_2_primary: 'required',  
                name_secondary: 'required',  
                relationship_secondary: 'required',  
                phone_secondary: 'required',  
                phone_2_secondary: 'required',  
            },  
            messages: {
                name_primary: 'Please input name primary',  
                relationship_primary: 'Please input relationship primary',  
                phone_primary: 'Please input phone primary',  
                phone_2_primary: 'Please input phone 2 primary',  
                name_secondary: 'Please input name secondary',  
                relationship_secondary: 'Please input relationship secondary',  
                phone_secondaryr: 'Please input phone secondary',  
                phone_2_secondary: 'Please input phone 2 secondary',  
            },  
            submitHandler: function(form) {  
                form.submit();
            }  
        });  
    </script>
    @endsection
@endsection