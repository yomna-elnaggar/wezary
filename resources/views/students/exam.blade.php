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
                        <h3 class="page-title">الامتحانات</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الامتحانات</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_exam"><i class="fa fa-plus"></i> اضافة امتحان</a>
                      
                        <a href=" {{url('exampdf/'.$student->id)}}" class="btn add-btn" ><i class="fa fa-plus"></i>  تحميل تقرير</a>
                  
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            {{-- message --}}
            {!! Toastr::message() !!}

            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                 
                                    <th>الدرجة</th>
                                    <th>الكورس</th>
                                  <th>المعلم</th>
                                    <th class="text-right no-sort">الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($exams as $items )
                                <tr>
                                    <td> {{ $items->name }}</td>
                                    <td>{{ $items->grade }}</td>
                                    <td>{{ $items->course_name }}</td>
                                    <td>{{ $items->teacher->name }}</td>
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete{{$items->id}}"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                              
                              <!-- Delete User Modal -->
                                <div class="modal custom-modal fade" id="delete{{$items->id}}" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                     <h3>حذف الطالب</h3>
                                                     <p>هل أنت متأكد أنك تريد الحذف؟</p>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <form action="{{ route('all/students/exams/delete') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id"  value="{{$items->id}}">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="submit" class="btn btn-primary continue-btn submit-btn">حذف</button>
                                                            </div>
                                                            <div class="col-6">
                                                                <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">الغاء</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <!-- /Delete User Modal -->
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
      
         <!-- Add Employee Modal -->
         <div id="add_exam" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">اضافة درجة امتحان </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <!-- Display validation errors here -->
                        <!-- Display validation errors here -->
                        <div id="errorContainer"></div>
                        <form action="{{ route('all/students/exams/save') }}" method="POST" enctype="multipart/form-data"  id="addTeacherForm">
                            @csrf
                          
                          <input class="form-control" type="hidden" id="student_id" name="student_id" value="{{ $student->id }}"> 
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">الاسم</label>
                                        <input class="form-control" type="text" id="name" name="name" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">الدرجة   <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="grade" name="grade" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">صورة <span class="text-danger">*</span></label>
                                        <input class="form-control" id="image" type="file" name="image">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الدورة</label>
                                        <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="course_id" name="course_id">
                                            <option value="">-- اختار --</option>
                                           @foreach ($courses as $item )
                                          		<option value="{{ $item->id}}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
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
        <!-- /Add Employee Modal -->>
    </div>
    <!-- /Page Wrapper -->
   
@endsection
