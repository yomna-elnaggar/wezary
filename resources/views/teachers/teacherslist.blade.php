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
                        <h3 class="page-title">المعلمون</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">المعلمون</li>
                        </ul>
                    </div>
                    <div class="col-auto float-right ml-auto">
                       @if (Auth::guard('admin')->user()->can('access any'))
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_employee"><i class="fa fa-plus"></i> اضافة المعلمون</a>
                       @endif
                      <div class="view-icons">
                            <a href="{{ route('all/teachers/card') }}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                            <a href="{{ route('all/teachers/list') }}" class="list-view btn btn-link"><i class="fa fa-bars"></i></a>
                        </div>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->

            <!-- Search Filter -->
            <form action="{{ route('all/teachers/list/search') }}" method="POST">
                @csrf
                <div class="row filter-row">
                    {{-- <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" name="employee_id">
                            <label class="focus-label">اسم المعلم</label>
                        </div>
                    </div> --}}
                    <div class="col-sm-6 col-md-3">  
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" name="name">
                            <label class="focus-label">Teacher Name</label>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3"> 
                        <div class="form-group form-focus">
                            <input type="text" class="form-control floating" name="department">
                            <label class="focus-label">القسم</label>
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
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table datatable">
                            <thead>
                                <tr>
                                    <th>الاسم</th>
                                 
                                    <th>البريد الإلكتروني</th>
                                    <th>رقم الهاتف المحمول</th>
                                    <th>القسم</th>
                                  	
                                    <th class="text-nowrap">تاريخ الانضمام</th>
                             		<th>الحالة</th>
                                    <th class="text-right no-sort">الاجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admins as $items )
                                <tr>
                                    <td>
                                        <h2 class="table-avatar">
                                            <a href="{{ url('teachers/profile/'.$items->id) }}" class="avatar"><img alt="" src="{{ URL::to($items->image) }}"></a>
                                            <a href="{{ url('teachers/profile/'.$items->id) }}">{{ $items->name }}<span>{{ $items->department }}</span></a>
                                        </h2>
                                    </td>
                                    
                                    <td>{{ $items->email }}</td>
                                    <td>{{ $items->phone_number }}</td>
                                    <td>{{ $items->department }}</td>
                                    <td>{{ $items->join_date }}</td>
                                    <td class="text-center">
                                      <div class="dropdown action-label">
                                        <a class="btn btn-white btn-sm btn-rounded " href="{{ url('all/teachers/active/'.$items->id) }}">
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
                                                <a class="dropdown-item" href="{{ url('all/teachers/view/edit/'.$items->id) }}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                                <a class="dropdown-item" href="{{url('all/teachers/delete/'.$items->id)}}"onclick="return confirm('Are you sure to want to delete it?')"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
                                            </div>
                                        </div>
                                       @endif 
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
      
         <!-- Add Employee Modal -->
         <div id="add_employee" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">اضافة المعلمون</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                       <!-- Display validation errors here -->
                        <!-- Display validation errors here -->
                        <div id="errorContainer"></div>
                        <form action="{{ route('all/teachers/save') }}" method="POST" enctype="multipart/form-data"  id="addTeacherForm">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">الاسم</label>
                                        <input class="form-control" type="text" id="name" name="name" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">البريد الإلكتروني  <span class="text-danger">*</span></label>
                                        <input class="form-control" type="email" id="email" name="email" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">رقم الهاتف المحمول  <span class="text-danger">*</span></label>
                                        <input class="form-control" type="text" id="phone_number" name="phone_number" >
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">صورة <span class="text-danger">*</span></label>
                                        <input class="form-control" id="image" type="file" name="image">
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">القسم </label>
                                        <input class="form-control" type="text" id="department" name="department" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الجنس</label>
                                        <select class="select form-control" style="width: 100%;" tabindex="-1" aria-hidden="true" id="gender" name="gender">
                                            <option value="Male">ذكر</option>
                                            <option value="Female">انثى</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="col-form-label">كلمة المرور</label>
                                        <input class="form-control" type="password" id="password" name="password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>الوصف  <span class="text-danger">*</span></label>
                                        <textarea rows="2" class="form-control" id="description" name="description"></textarea>
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
    @section('script')
    <script>
        $("input:checkbox").on('click', function()
        {
            var $box = $(this);
            if ($box.is(":checked"))
            {
                var group = "input:checkbox[class='" + $box.attr("class") + "']";
                $(group).prop("checked", false);
                $box.prop("checked", true);
            } else {
                $box.prop("checked", false);
            }
        });
    </script>
    
    <script>
        // select auto id and email
        $('#name').on('change',function()
        {
            $('#employee_id').val($(this).find(':selected').data('employee_id'));
            $('#email').val($(this).find(':selected').data('email'));
        });
    </script>

<script>
    $(document).ready(function() {
        $('#addTeacherForm').submit(function(e) {
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
                    toastr.success('Teacher added successfully!');
                    // Close the modal after 2 seconds (adjust the time as needed)
                    
                        $('#add_employee').modal('hide');
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
