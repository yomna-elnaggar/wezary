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
                        <h3 class="page-title">الطلاب</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">الطلاب</li>
                        </ul>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            <!-- Search Filter -->
            <form action="{{ route('all/students/search') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="name" name="name">
                            <label class="focus-label">اسم الطالب</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3"> 
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" id="special_code" name="special_code">
                            <label class="focus-label"> كود الطالب</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">  
                        <button type="sumit" class="btn btn-success btn-block btn_search"> بحث </button>  
                    </div>
                </div>
            </form>

            {{-- message --}}
            {!! Toastr::message() !!}

            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                    <th>كود الطالب</th>
                                    <th>رقم الهاتف</th>
                                    <th>هاتف ولي الأمر </th>
                                    <th>المستوي الدراسي</th>
                                    <th>المرحلة الدراسية</th>
                                  	<th>الحالة</th>
                                    <th class="text-right no-sort">الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($students as $items )
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ url('all/students/profile/'.$items->id) }}" class="avatar"><img alt="" src="{{ URL::to($items->image) }}"></a>
                                            <a href="{{ url('all/students/profile/'.$items->id) }}">{{ $items->name }}</a>
                                        </h2>
                                    </td>
                                    <td>{{ $items->special_code }}</td>
                                    <td>{{ $items->numberPart }}</td>
                                    <td>{{ $items->parent_numberPart }}</td>
                                    <td>{{ $items->academicLevel_name }}</td>
                                    <td>{{ $items->stageLevel_name }}</td>
                                  	<td class="text-center">
                                      <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded " href="{{ url('all/students/active/'.$items->id) }}">
                                          <i 
                                             @if($items->status =='active')
                                             class="fa fa-dot-circle-o text-success"
                                            @else
                                             class="fa fa-dot-circle-o text-danger"
                                            @endif
                                             ></i>{{ $items->status === 'active' ? 'نشط' : 'متوقف';}}
                                        </a>
                                      </div>
                                    </td>
                                    <td class="text-right">
                                      @if (Auth::guard('admin')->user()->can('access any'))
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#delete_user{{$items->id}}"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                              	<a class="dropdown-item" href="#" data-toggle="modal" data-target="#two_div{{$items->id}}"><i class="fa fa-trash-o m-r-5"></i> أكثر من جهاز</a>
                                            </div>
                                        </div>
                                      @endif
                                    </td>
                                </tr>
                                 <!-- Delete User Modal -->
                                    <div class="modal custom-modal fade" id="delete_user{{$items->id}}" role="dialog">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-body">
                                                    <div class="form-header">
                                                        <h3>حذف الطالب</h3>
                                                        <p>هل أنت متأكد أنك تريد الحذف؟</p>
                                                    </div>
                                                    <div class="modal-btn delete-action">
                                                        <form action="{{ route('all/students/delete') }}" method="POST">
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

                                <!-- Delete User Modal -->
                                <div class="modal custom-modal fade" id="two_div{{$items->id}}" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="form-header">
                                                    
                                                    <p>هل تريد منح هذا الطالب صلاحيه الدخول من جهازين</p>
                                                </div>
                                                <div class="modal-btn delete-action">
                                                    <form action="{{ route('all/students/twoDiv') }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id"  value="{{$items->id}}">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <button type="submit" class="btn btn-primary continue-btn submit-btn">السماح</button>
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
				
       
    </div>
    <!-- /Page Wrapper -->
    @section('script')



    @endsection

@endsection
