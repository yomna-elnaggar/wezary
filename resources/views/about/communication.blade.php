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
                        <h3 class="page-title">تواصل</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home')}}">لوحة التحكم </a></li>
                            <li class="breadcrumb-item active">تواصل</li>
                        </ul>
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
                                    <th>Linkedin</th>
                                    <th>Facebook</th>
                                    <th>Telegram</th>
                                    <th>Whatsapp</th>
                                    <th>Google</th>
                             
                                    <th class="text-right no-sort">أجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($Communications as $items )
                                <tr>
                                    <td>{{ $items->Linkedin }}</td>
                                    <td>{{ $items->Facebook }}</td>
                                    <td>{{ $items->Telegram }}</td>
                                    <td>{{ $items->Whatsapp }}</td>
                                    <td>{{ $items->Google }}</td>
                                    
                                    <td class="text-right">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#edit_Communication{{$items->id}}"><i class="fa fa-pencil m-r-5"></i> تعديل</a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <!-- edit Communication Modal -->
                                <div id="edit_Communication{{$items->id}}" class="modal custom-modal fade" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">تعديل</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            
                                                <form action="{{ route('all/Communication/update', 'updateCommunication') }}" method="POST" >
                                                    @csrf 
                                                    <input type="hidden" class="form-control" id="id" name="id" value="{{ $items->id}}">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Linkedin</label>
                                                                <input class="form-control" type="text"  name="Linkedin" value="{{$items->Linkedin}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Facebook </label>
                                                                <input class="form-control" type="text"  name="Facebook" value="{{$items->Facebook}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Telegram </label>
                                                                <input class="form-control" type="text" id="code" name="Telegram" value="{{$items->Telegram}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Whatsapp </label>
                                                                <input class="form-control" type="text" id="code" name="Whatsapp" value="{{$items->Whatsapp}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label>Google </label>
                                                                <input class="form-control" type="text" id="code" name="Google" value="{{$items->Google}}">
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
                                <!-- /edit Communication Modal -->
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

@endsection
