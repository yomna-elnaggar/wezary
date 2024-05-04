@extends('layouts.master')
@section('content')
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title"> ملف الدورة</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم </a></li>
                            <li class="breadcrumb-item active"><a href="{{ route('all/courses/card') }}"> الدورات </a></li>
                        </ul>
                    </div>
                  @if (Auth::guard('admin')->user()->can('access any'))
                    <div class="col-auto float-right ml-auto">
                      <div class="text-muted">
                        <form action="{{ url('all/courses/GenerateCode', $course->id) }}" method="post">
                          @csrf
                          <button type="submit" class="btn add-btn" data-course-id="{{ $course->id }}">
                              إنشاء رمز
                          </button>
                        </form>
                      </div>
                    </div> 
                  @endif

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
                                        <a href="#"><img alt="" src="{{asset($course->image)}}" alt="{{ $course->name }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $course->name }}</h3>
                                                <h6 class="text-muted"> {{ $course->department_name }}</h6>
                                                <small class="text-muted">{{ $course->description }}</small>
                                                {{-- <div class="staff-id">Employee ID : {{ $course->user_id }}</div>
                                                <div class="small doj text-muted">Date of Join : {{ $course->join_date }}</div>
                                                <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title"> المستوي الدراسي:</div>
                                                    <div class="text">
                                                        @if(!empty($course->academicLevel_name))
                                                            <a>{{ $course->academicLevel_name }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title"> المرحلة الدراسية:</div>
                                                    <div class="text">
                                                        @if(!empty($course->stageLevel_name))
                                                        <a>{{ $course->stageLevel_name }}</a>
                                                        @else
                                                            <a>N/A</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">المدة الإجمالية:</div>
                                                    <div class="text">
                                                        @php
                                                        $totalMinutes = $course->subjects->sum('totale_min');
                                                        $totalSeconds = $course->subjects->sum('totale_sec');

                                                        // Convert total seconds to minutes and add to total minutes
                                                        $totalMinutes += round($totalSeconds / 60);

                                                        $hours = floor($totalMinutes / 60);
                                                        $minutes = $totalMinutes % 60;
                                                        @endphp

                                                        @if($totalMinutes > 0)
                                                            <a>{{ $hours }} h {{ $minutes }} m</a>
                                                        @else
                                                            <a>0</a>
                                                        @endif
                                                    </div>
                                                </li>

                                                <li>
                                                    <div class="title">عدد الدروس:</div>
                                                    <div class="text">
                                                        @if(!empty($course->subjects))
                                                        <a>{{ $course->subjects->count() }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
					
            <div class="card tab-box">
                <div class="row user-tabs">
                    <div class="col-lg-12 col-md-12 col-sm-12 line-tabs">
                        <ul class="nav nav-tabs nav-tabs-bottom">
                            <li class="nav-item"><a href="#emp_Subject" data-toggle="tab" class="nav-link active">الدروس</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Subjects Tab -->
                <div id="emp_Subject" class="pro-overview tab-pane fade show active">
                    <h3 class="card-title">دروسي <a href="#" class="edit-icon" data-toggle="modal" data-target="#addSubject"><i class="fa fa-pencil"></i></a></h3>
                    <div class="row">
                        @foreach($subjects as $subject)
                        <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                            <div class="card">
                                <div class="card-body">
                                    <div class="dropdown profile-action">
                                        <a aria-expanded="false" data-toggle="dropdown" class="action-icon dropdown-toggle" href="#"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a data-target="#edit_subject{{$subject->id}}" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            <a data-target="#delete_subject{{$subject->id}}" data-toggle="modal" href="#" class="dropdown-item"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                        </div>
                                    </div>
                                    <h4 class="project-title"> {{ Str::limit($subject->name, 25, '...') }}</h4>
                                    <small class="block text-ellipsis ">
                                        <span class="text-muted"><a href="{{$subject->link}}">{{$subject->link}}</a></span>
                                    </small>
                                    <small class="block text-ellipsis">
                                        <span class="text-muted">{{$subject->totale_min}}m {{$subject->totale_sec}}s </span>
                                    </small>
                                    <!--<div>
                                        <p style="margin-bottom: 0;">{{ Str::limit($subject->description, 50, '...') }}</p>
                                        <small><a href="#" data-toggle="modal" data-target="#subjectModal{{ $subject->id }}"style="color: #000000;">Read More</a></small>
                                    </div>-->
                                    <div class="pro-deadline m-b-5">
                                        <div class="sub-title">
                                           رابط درايف:
                                        </div>
                                        <div class="text-muted">
                                            <a href="{{$subject->drive_link}}" data-toggle="tooltip" title="{{$subject->drive_link}}">رابط الملفات في درايف   </a>
                                        </div>
                                    </div>                                    
                                    <div class="pro-deadline m-b-15">
                                        <div class="text-muted">
                                            <button type="submit" class="btn {{ $subject->status == 'free' ? 'btn-success' : 'btn-danger' }}">
                                                {{ $subject->status == 'free' ? 'مجاني' :  'مدفوع' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- more Modal -->
                        <div class="modal fade" id="subjectModal{{$subject->id}}" tabindex="-1" role="dialog" aria-labelledby="subjectModalLabel{{$subject->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="subjectModalLabel{{$subject->id}}">{{$subject->title}}</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>{{$subject->description}}</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                                    </div>
                                </div>
                            </div>
                        </div>
					    <!-- more Modal -->
                        <!-- Edit subject Modal -->
                        <div id="edit_subject{{$subject->id}}" class="modal custom-modal fade" role="dialog">
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">تعديل </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('all/subject/update', 'updateRecord') }}" method="POST" enctype="multipart/form-data"  id="editCourseForm">
                                            @csrf 
                                            <input type="hidden" class="form-control" id="id" name="id" value="{{ $subject->id}}">
                                            <input type="hidden" class="form-control" id="course_id" name="course_id" value="{{ $course->id}}">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>الاسم </label>
                                                        <input class="form-control" type="text" id="name" name="name" value="{{$subject->name}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>رابط الدرس</label>
                                                        <input class="form-control" type="text" name="link" value="{{$subject->link}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>إجمالي الدقائق</label>
                                                        <input class="form-control" type="number" name="totale_min" value="{{$subject->totale_min}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>إجمالي الثواني</label>
                                                        <input class="form-control" type="number" name="totale_sec" value="{{$subject->totale_sec}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>حالة الدرس<span class="text-danger">*</span></label>
                                                        <select class="select form-control" name="status">
                                                            <option value="{{$subject->status}}">{{$subject->status}}</option>
                                                            <option value="free">مجاني </option>
                                                            <option value="notFree">مدفوع</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>لينك درايف</label>
                                                        <input class="form-control" type="text" name="drive_link" value="{{$subject->drive_link}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>الوصف</label>
                                                        <textarea rows="4" class="form-control summernote" placeholder="Enter description here" name="description">{{$subject->description}}</textarea>
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
                        <!-- /Edit subject Modal -->
                        
                        <!-- Delete subject Modal -->
                        <div class="modal custom-modal fade" id="delete_subject{{$subject->id}}" role="dialog">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-header">
                                            <h3>حذف الدرس</h3>
                                            <p>هل أنت متأكد أنك تريد الحذف؟</p>
                                        </div>
                                        <div class="modal-btn delete-action">
                                            <form action="{{ url('all/subject/delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id"  value="{{$subject->id}}">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">حذف</button>
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
                        <!-- /Delete subject Modal -->
                        @endforeach
                    </div>
                </div>
                <!-- /Subjects Info Tab -->
            </div>
        </div>
        <!-- /Page Content -->

        <!-- Subjects Info Modal -->
				<div id="addSubject" class="modal custom-modal fade" role="dialog">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"> درس جديد</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<!-- Display validation errors here -->
                                <div id="errorContainer"></div>
                                <form action="{{ route('all/subject/save') }}" method="POST" enctype="multipart/form-data"  id="addSubjectForm">
                                    @csrf 
                                    <input type="hidden" class="form-control" id="course_id" name="course_id" value="{{ $course->id}}">
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label>الاسم </label>
												<input type="text" class="form-control" name="name">
											</div>
										</div>
                                        <div class="col-md-6">
											<div class="form-group">
												<label>رابط الدرس </label>
												<input class="form-control" type="text" name="link">
											</div>
										</div>
										<div class="col-md-6">
                                            <div class="form-group">
                                                <label>إجمالي الدقائق</label>
                                                <input class="form-control" type="number" name="totale_min">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>إجمالي الثواني</label>
                                                <input class="form-control" type="number" name="totale_sec">
                                            </div>
                                        </div>
										<div class="col-md-6">
											<div class="form-group">
												<label>حالة الدرس <span class="text-danger">*</span></label>
												<select class="select form-control" name="status">
													<option>-</option>
													<option value="free">مجاني </option>
													<option value="notFree">مدفوع</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label>لينك درايف</label>
												<input class="form-control" type="text" name="drive_link">
											</div>
										</div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>الوصف</label>
                                                <textarea rows="4" class="form-control summernote" placeholder="أدخل الوصف هنا" name="description"></textarea>
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
        <!-- /Subjects Info Modal -->
    
       <!-- Create code Modal -->
        <div class="modal fade" id="create_course_modal" tabindex="-1" role="dialog" aria-labelledby="createCourseModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createCourseModalLabel">إنشاء رمز  </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('all/save-course-code') }}" method="POST">
                        <input type="hidden" class="form-control" id="course_id" name="course_id" value="{{ $course->id}}">
                            @csrf
                        <p>الرمز:</p>
                        <input type="text" class="form-control" name="generated_code_input" id="generated_code_input" readonly>
                        <div class="submit-section">
                          <button class="btn btn-primary submit-btn">حفظ</button>
                        </div>
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- /Page Content -->
    </div>
    @section('script')

  <script>
        $(document).ready(function() {
            // Event listener for the "Create Course" button click
            $('.add-btn').click(function(e) {
                e.preventDefault();
                // Generate a random 6-character alphanumeric code
                var code = Math.random().toString(36).substring(2, 8).toUpperCase();
                // Display the generated code in the modal
                $('#generated_code_input').val(code);
                // Show the modal
                $('#create_course_modal').modal('show');
            });
        });
    </script>
   <script>
        $(document).ready(function() {
            $('#addSubjectForm').submit(function(e) {
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
                        toastr.success('Subject added successfully!');
                        // Close the modal after 2 seconds (adjust the time as needed)
                        
                            $('#addSubject').modal('hide');
                            // Reload the page after successful submission
                            window.location.reload();
                        // Optionally, reload the page or update the data in the current page
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