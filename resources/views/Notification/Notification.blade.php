
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
                        <h3 class="page-title">إشعارات </h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">إشعارات </li>
                        </ul>
                    </div>
                   @if(Auth::guard('admin')->user()->can('access any'))
                    <div class="col-auto float-right ml-auto">
                        <a href="#" class="btn add-btn" data-toggle="modal" data-target="#add_StageLevel"><i class="fa fa-plus"></i> إشعارات </a>
                    </div>
                  @endif
                </div>
            </div>

            <!-- /Page Header -->
            {!! Toastr::message() !!}
            
        </div>
        <!-- /Page Content -->
        
        <!-- Add StageLevel Modal -->
        <div id="add_StageLevel" class="modal custom-modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">اضافة إشعارات</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Display validation errors here -->
                        <div id="errorContainer"></div>
                        <form action="{{ route('all/Notification/saveRecord') }}" method="POST" id="addStageForm">
                            @csrf
                            <div class="form-group">
                                <label>العنوان <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label>الوصف <span class="text-danger">*</span></label>
                                <input class="form-control @error('name') is-invalid @enderror" type="text" id="body" name="body">
                            </div>
                            <div class="submit-section">
                                <button type="submit" class="btn btn-primary submit-btn">ارسال</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Add StageLevel Modal -->
     
    </div>


@endsection
