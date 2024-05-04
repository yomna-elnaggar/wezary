
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
                        <h3 class="page-title">المرحلة الدراسية</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">المرحلة الدراسية</li>
                        </ul>
                    </div>
                   @if(Auth::guard('admin')->user()->can('access any'))
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_StageLevel"><i class="fa fa-plus"></i>اضافة المرحلة الدراسية </a>
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
                                    <th>اسم المرحلة الدراسية</th>
                                    <th>اسم المستوي الدراسي</th>
                                    <th class="text-right">اجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stageLevels as $key=>$items )
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td hidden class="id">{{ $items->id }}</td>
                                    <td class="StageLevel">{{ $items->name }}</td>
                                    <td  class="academicLevel">{{ $items->academicLevel_name }}</td>
                                    <td class="text-right">
                                    @if(Auth::guard('admin')->user()->can('access any'))
                                    <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item  edit_StageLevel" href="#" data-toggle="modal" data-target="#edit_StageLevel_{{ $items->id }}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                             <a href="#" class="dropdown-item delete_edit_StageLevel" data-toggle="modal" data-target="#delete_StageLevel_{{ $items->id }}">
                                                <i class="fa fa-trash-o m-r-5"></i> حذف
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                    </td>
                                  <!-- Delete StageLevel Modal -->
                                  <div class="modal custom-modal fade" id="delete_StageLevel_{{ $items->id }}" role="dialog">
                                      <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">
                                              <div class="modal-body">
                                                  <div class="form-header">
                                                      <h3>حذف المرحلة الدراسية</h3>
                                                      <p>هل أنت متأكد أنك تريد الحذف؟</p>
                                                  </div>
                                                  <div class="modal-btn delete-action">
                                                      <form action="{{ route('form/stageLevel/delete') }}" method="POST">
                                                          @csrf
                                                          <input type="hidden" name="id" value="{{$items->id}}">
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
                                  <!-- /Delete StageLevel Modal -->
                                  
                                  
                                   <!-- Edit StageLevel Modal -->
                                  <div id="edit_StageLevel_{{ $items->id }}" class="modal custom-modal fade" role="dialog">
                                      <div class="modal-dialog modal-dialog-centered" role="document">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title">تعديل المرحلة الدراسية</h5>
                                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                  </button>
                                              </div>
                                              <div class="modal-body">
                                                  <form action="{{ route('form/stageLevel/update') }}" method="POST">
                                                      @csrf
                                                      <input type="hidden" name="id"  value="{{$items->id}}">
                                                      <div class="form-group">
                                                          <label>اسم المرحلة الدراسية<span class="text-danger">*</span></label>
                                                          <input type="text" class="form-control" id="StageLevel_edit" name="name" value="{{ $items->name }}">
                                                      </div>
                                                      <div class="form-group">
                                                          <label>اسم المستوي الدراسي <span class="text-danger">*</span></label>
                                                          <select class="select form-control" id="academic_level_id" name="academic_level_id">
                                                              <option value="{{$items->academic_level_id}}"{{ ( $items->academic_level_id == $items->academic_level_id) ? 'selected' : '' }}>{{ $items->academicLevel_name}}</option>
                                                              @foreach ($academicLevel as $key=>$item)
                                                                  <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                              @endforeach
                                                          </select>
                                                      </div>

                                                      <div class="submit-section">
                                                          <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                                                      </div>
                                                  </form>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                  <!-- /Edit StageLevel Modal -->
                                </tr>
                              
                              
                                  
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        
        <!-- Add StageLevel Modal -->
        <div id="add_StageLevel" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">اضافة المرحلة الدراسية</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display validation errors here -->
                        <div id="errorContainer"></div>
                        <form action="{{ route('form/stageLevel/save') }}" method="POST" id="addStageForm">
                            @csrf
                            <div class="form-group">
                                <label>اسم اضافة المرحلة الدراسية <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="name" name="name">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label> المستوي الدراسي <span class="text-danger">*</span></label>
                                <select class="select form-control"   id="academic_level_id" name="academic_level_id">
                                    <option value="">-- اختيار --</option>
                                    @foreach ($academicLevel as $key=>$item )
                                        <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add StageLevel Modal -->
        
       

    </div>

    <!-- /Page Wrapper -->
    @section('script')
    
   


<script>
    $(document).ready(function() {
        $('#addStageForm').submit(function(e) {
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
                    toastr.success('Stage Level added successfully!');
                    // Close the modal after 2 seconds (adjust the time as needed)
                    $('#add_StageLevel').modal('hide');
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
