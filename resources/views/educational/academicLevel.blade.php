
@extends('layouts.master')
@section('content')
   
    <!-- Page Wrapper -->
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">


                <div class="row align-items-center">
                    <div class="col">
                        <h3 class="page-title"> المستوي الدراسي</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم </a></li>
                            <li class="breadcrumb-item active"> المستوي الدراسي</li>
                        </ul>
                    </div>
                  @if(Auth::guard('admin')->user()->can('access any'))
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_academicLevel"><i class="fa fa-plus"></i> إضافة المستوى الدراسي</a>
                    </div>
                  @endif
                </div>
            </div>

            <!-- /Page Header -->
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <table class="table table-striped custom-table mb-0 datatable">
                            <thead>
                                <tr>
                                    <th style="width: 30px;">#</th>
                                    <th>اسم المستوى الدراسي</th>
                                    <th class="text-right">الإجراء</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($academicLevel as $key=>$items )
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td class="academicLevel">{{ $items->name }}</td>
                                    <td class="text-right">
                                    @if(Auth::guard('admin')->user()->can('access any'))
                                    <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item  edit_academicLevel" href="#" data-toggle="modal" data-target="#edit_academicLevel"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            <a class="dropdown-item delete_academicLevel" href="#" data-toggle="modal" data-target="#delete_academicLevel"><i class="fa fa-trash-o m-r-5"></i> حذف</a>
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
        
        <!-- Add academicLevel Modal -->
        <div id="add_academicLevel" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">إضافة المستوى الدراسي</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/academicLevel/save') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>اسم المستوى الدراسي <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add academicLevel Modal -->
        
        <!-- Edit academicLevel Modal -->
        <div id="edit_academicLevel" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">تعديل </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('form/academicLevel/update') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id" id="e_id" value="">
                            <div class="form-group">
                                <label>اسم المستوى الدراسي  <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="academicLevel_edit" name="name" value="">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Edit academicLevel Modal -->

        <!-- Delete academicLevel Modal -->
        <div class="modal custom-modal fade" id="delete_academicLevel" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="form-header">
                            <h3>حذف المستوى الدراسي</h3>
                            <p>هل أنت متأكد أنك تريد الحذف؟</p>
                        </div>
                        <div class="modal-btn delete-action">
                            <form action="{{ route('form/academicLevel/delete') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" class="e_id" value="">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary continue-btn submit-btn">حذف</button>
                                    </div>
                                    <div class="col-6">
                                        <a href="javascript:void(0);" data-dismiss="modal" class="btn btn-primary cancel-btn">الإلغاء</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Delete academicLevel Modal -->
    </div>

    <!-- /Page Wrapper -->
    @section('script')
    {{-- update js --}}
    <script>
        $(document).on('click','.edit_academicLevel',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#academicLevel_edit').val(_this.find('.academicLevel').text());
        });
    </script>
    {{-- delete model --}}
    <script>
        $(document).on('click','.delete_academicLevel',function()
        {
            var _this = $(this).parents('tr');
            $('.e_id').val(_this.find('.id').text());
        });
    </script>
    @endsection
@endsection
