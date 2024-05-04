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
                   <div class="col-auto float-right ml-auto">
                     
                        <a href=" {{url('generate-pdf/'.$teacher->id)}}" class="btn add-btn" ><i class="fa fa-plus"></i>  تحميل تقرير</a>
                  
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
                                        <a href="#"><img alt="" src="{{ URL::to($teacher->image) }}" alt="{{ $teacher->name }}"></a>
                                    </div>
                                </div>
                                <div class="profile-basic">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="profile-info-left">
                                                <h3 class="user-name m-t-0 mb-0">{{ $teacher->name }}</h3>
                                                <h6 class="text-muted"> {{ $teacher->department }}</h6>
                                                <small class="text-muted">{{ $teacher->description }}</small>
                                                {{-- <div class="staff-id"> ID : {{ $teacher->user_id }}</div> --}}
                                                {{-- <div class="small doj text-muted">تاريخ الانضمام : {{ $teacher->join_date }}</div> --}}
                                                {{-- <div class="staff-msg"><a class="btn btn-custom" href="chat.html">Send Message</a></div> --}}
                                            </div>
                                        </div>
                                        <div class="col-md-7">
                                            <ul class="personal-info">
                                                <li>
                                                    <div class="title">رقم الهاتف :</div>
                                                    <div class="text">
                                                        @if(!empty($teacher->phone_number))
                                                            <a>{{ $teacher->phone_number }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">البريد الإلكتروني:</div>
                                                    <div class="text">
                                                        @if(!empty($teacher->email))
                                                        <a>{{ $teacher->email }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">تاريخ الانضمام:</div>
                                                    <div class="text">
                                                        @if(!empty($teacher->join_date))
                                                        <a>{{ $teacher->join_date }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">القسم:</div>
                                                    <div class="text">
                                                        @if(!empty($teacher->department))
                                                        <a>{{ $teacher->department }}</a>
                                                        @else
                                                            <a>غير متوفر</a>
                                                        @endif
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="title">الجنس:</div>
                                                    <div class="text">
                                                        @if(!empty($teacher->gender))
                                                        <a>{{ $teacher->gender }}</a>
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
                            <li class="nav-item"><a href="#emp_profile" data-toggle="tab" class="nav-link active">الملف الشخصي</a></li>
                            <li class="nav-item"><a href="#emp_projects" data-toggle="tab" class="nav-link">الدورات</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            
            <div class="tab-content">
                <!-- Students Info Tab -->
                <div id="emp_profile" class="pro-overview tab-pane fade show active">
                    <div class="row">
                        <div class="col-md-12 d-flex">
                            <div class="card profile-box flex-fill">
                                <div class="card-body">
                                    <h3 class="card-title">الطلاب </h3>
                                    <div class="table-responsive">
                                        <table class="table table-nowrap">
                                            <thead>
                                                <tr>
                                                    <th>كود الطالب </th>
                                                    <th>الاسم</th>
                                                    <th>هاتف الوالد</th>
                                                    <th>رقم الهاتف </th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                              @foreach($allUsers as $user)
                                                <tr>
                                                    <td>{{$user->special_code}}</td>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->parent_phone}}</td>
                                                    <td>{{$user->phone_number}}</td>
                                                  	
                                                </tr>
                                              @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /Students Info Tab -->
                
                <!-- Courses Tab -->
                <div class="tab-pane fade" id="emp_projects">
                    <div id="emp_courses" class="pro-overview tab-pane fade show active">
                        <div class="row">
                            @foreach($courses as $course)
                            <div class="col-lg-4 col-sm-6 col-md-4 col-xl-3">
                              <div class="card">
                                <div class="card-body">
                                  <h4 class="project-title" style="margin-bottom: 0;"><a href="{{url('courses/profile/'.$course->id)}}">{{ Str::limit($course->name, 25, '...') }}</a></h4>
                                  <small class="block text-ellipsis m-b-15">
                                    <span class="text-xs"></span> <span class="text-muted">{{$course->academicLevel_name}}, </span>
                                    <span class="text-xs"></span> <span class="text-muted">{{$course->stageLevel->name}}</span>
                                  </small>
                                  <div class="pro-deadline m-b-15">
                                    <div class="sub-title">
                                      قسم الدورة:
                                    </div>
                                    <div class="text-muted">
                                      <a href="#" data-toggle="tooltip" title="Jeffery Lalor"  style="color: #000000;">{{$course->department_name}}</a>
                                    </div>
                                  </div>
                                  <div class="pro-deadline m-b-15">
                                    <div class="text-muted">
                                      <form action="{{ url('all/courses/approv', $course->id) }}" method="post">
                                        @csrf
                                        <button type="submit" class="btn {{ $course->status == 'active' ? 'btn-success' : 'btn-danger' }}">
                                          {{ $course->status == 'active' ? 'موافق' : 'غير موافق' }}
                                        </button>
                                      </form>
                                    </div>
                                  </div>

                                </div>
                              </div>
                          </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <!-- /Courses Tab -->
            </div>
        </div>
        <!-- /Page Content -->
    
        
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