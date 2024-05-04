
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
                        <h3 class="page-title">الدورات</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم </a></li>
                            <li class="breadcrumb-item active">الدورات</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#create_project"><i class="fa fa-plus"></i> إنشاء دورة</a>
                        {{-- <div class="view-icons">
                            <a href="projects.html" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            <a href="project-list.html" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            
            <!-- Search Filter -->
            <form action="{{ route('all/courses/search') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" name="name">
                            <label class="focus-label">الاسم</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" name="admin_name">
                            <label class="focus-label">اسم المعلم</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <button type="sumit" class="btn btn-success btn-block"> بحث </button>  
                    </div>
                </div>
            </form>
            <!-- Search Filter -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                @foreach($courses as $course)
                <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                    <div class="card">
                        <div class="card-body">
                           @if (Auth::guard('admin')->user()->can('access any')||Auth::guard('admin')->user()->id == $course->admin_id )
                            <div class="dropdown dropdown-action profile-action">
                                <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_project{{$course->id}}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_project{{$course->id}}"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                </div>
                            </div>
                          @endif
                            <h4 class="project-title" style="margin-bottom: 0;"><a href="{{url('courses/profile/'.$course->id)}}">{{ Str::limit($course->name, 25, '...') }}</a></h4>
                            <small class="block text-ellipsis m-b-5">
                                <span class="text-xs"></span> <span class="text-muted">{{$course->academicLevel_name}}, </span>
                                <span class="text-xs"></span> <span class="text-muted">{{$course->stageLevel->name}}</span>
                            </small>
                            <div class="pro-deadline m-b-5 text-right">
                                <div class="sub-title text-right">
                                  : مدرس الدورة
                                </div>
                                <div class="text-muted text-right">
                                    <a href="#" data-toggle="tooltip"  style="color: #000000;">{{$course->teacher->name}}</a>
                                </div>
                            </div>
                            <div class="pro-deadline m-b-5 text-right">
                                <div class="sub-title text-right">
                                   : قسم الدورة
                                </div>
                                <div class="text-muted">
                                    <a href="#" data-toggle="tooltip"   style="color: #000000;">{{$course->department_name}}</a>
                                </div>
                            </div>
                          @if (Auth::guard('admin')->user()->can('access any'))
                            <div class="pro-deadline m-b-5">
                                <div class="text-muted">
                                    <form action="{{ url('all/courses/approv', $course->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn {{ $course->status == 'active' ? 'btn-success' : 'btn-danger' }}">
                                            {{ $course->status == 'active' ? 'موافق' : 'غير موافق ' }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                          @endif
                            
                        </div>
                    </div>
                </div>
                <!-- Edit Project Modal -->
                <div id="edit_project{{$course->id}}" class="modal custom-modal fade" role="dialog">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">تعديل </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('all/courses/update', 'updateRecord') }}" method="POST" enctype="multipart/form-data"  id="editCourseForm">
                                    @csrf 
                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $course->id}}">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>الاسم </label>
                                                <input class="form-control" type="text" id="name" name="name" value="{{$course->name}}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>اختار المستوي الدراسي </label>
                                                <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="academic_level_id" name="academic_level_id" onchange="console.log($(this).val())">
                                                    <option value="{{$course->academic_level_id}}"{{ ( $course->academic_level_id == $course->academic_level_id) ? 'selected' : '' }}>{{ $course->academicLevel->name}}</option>
                                                    @foreach ($academicLevel as $key=>$item )
                                                        <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>اختار المرحلة الدراسية </label>
                                                <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="stage_level_id" name="stage_level_id">
                                                    <option value="{{$course->stage_level_id}}" {{ ( $course->stage_level_id == $course->stage_level_id) ? 'selected' : '' }} >{{ $course->stageLevel->name}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>القسم</label>
                                                <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="department_id" name="department_id">
                                                    <option value="{{$course->department_id}}"{{ ( $course->department_id == $course->department_id) ? 'selected' : '' }}>{{ $course->department_name}}</option>
                                                    @foreach ($departments as $key=>$item )
                                                    <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="col-form-label">الصورة <span class="text-danger">*</span></label>
                                                <input class="form-control" id="image" type="file" name="image">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Description</label>
                                                <textarea rows="4" class="form-control summernote" placeholder="Enter your message here" name="description">{{$course->description}}</textarea>
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
                <div class="modal custom-modal fade" id="delete_project{{$course->id}}" role="dialog">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="form-header">
                                    <h3>حذف  الدورة</h3>
                                    <p>هل أنت متأكد أنك تريد الحذف؟</p>
                                </div>
                                <div class="modal-btn delete-action">
                                    <form action="{{ url('all/courses/delete') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id"  value="{{$course->id}}">
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
                <!-- /Delete Project Modal -->
                @endforeach
            </div>
        </div>
        <!-- /Page Content -->
        <!-- Create Course Modal -->
        <div id="create_project" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إنشاء دورة</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <!-- Display validation errors here -->
                        <div id="errorContainer"></div>
                        <form action="{{ route('all/courses/save') }}" method="POST" enctype="multipart/form-data"  id="addCourseForm">
                            @csrf 
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>اسم الدورة </label>
                                        <input class="form-control" type="text" id="name" name="name">
                                    </div>
                                </div>
                              
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> اختار المستوي الدراسي </label>
                                        <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="academic_level_id" name="academic_level_id" onchange="console.log($(this).val())">
                                            <option value="">-- اختار --</option>
                                            @foreach ($academicLevel as $key=>$item )
                                                <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>اختار المرحلة الدراسية</label>
                                        <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="stage_level_id" name="stage_level_id">
                                            <option value="">-- اختار --</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>القسم</label>
                                        <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="department_id" name="department_id">
                                            <option value="">-- اختار --</option>
                                            @foreach ($departments as $key=>$item )
                                            <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
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
                                        <label>الوصف</label>
                                        <textarea rows="4" class="form-control summernote" placeholder="أدخل رسالتك هنا" name="description"></textarea>
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
        <!-- /Create Course Modal -->
        
    
        
    </div>
    <!-- /Page Wrapper -->
    @section('script')
    <script>
        $(document).ready(function() {
            $('#addCourseForm').submit(function(e) {
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
                        toastr.success('Department added successfully!');
                        // Close the modal after 2 seconds (adjust the time as needed)
                        
                            $('#create_project').modal('hide');
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

    <script>
        $(document).ready(function () {
            $('select[name="academic_level_id"]').on('change', function () {
                var academic_level_id = $(this).val();
                if (academic_level_id) {
                    $.ajax({
                        url: "{{ URL::to('stageLevel') }}/" + academic_level_id,
                        type: "GET",
                        dataType: "json",
                        success: function (data) {
                            $('select[name="stage_level_id"]').empty();
                            $.each(data, function (key, value) {
                                $('select[name="stage_level_id"]').append('<option value="' + key + '">' + value + '</option>');
                            });
                        },
                    });
                } else {
                    console.log('AJAX load did not work');
                }
            });
        });
    </script>


    @endsection

@endsection
