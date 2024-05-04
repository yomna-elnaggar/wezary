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
                        <h3 class="page-title">عرض القسم </h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">تعديل القسم</li>
                        </ul>
                    </div>
                </div>
            </div>
			<!-- /Page Header -->
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title mb-0">تعديل القسم</h4>
                        </div>
                        <div class="card-body">
                            @if (count($errors) > 0)
                            <ul>
                                @foreach ($errors->all() as $item)
                                    <li class="text-danger">
                                        {{ $item }}
                                    </li>
                                @endforeach
                            </ul>
                            @endif
                            <form action="{{ route('all/department/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $department->id }}">
                                <input  type="hidden" name='old_icon' value="{{$department->icon}}" >
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">اسم القسم</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $department->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">المستوي الدراسي</label>
                                    <div class="col-md-10">
                                        <select class="select form-control" id="academic_level_id" name="academic_level_id" onchange="console.log($(this).val())">
                                            <option value="{{ $department->academic_level_id }}" {{ ( $department->academic_level_id == $department->academic_level_id) ? 'selected' : '' }}>{{ $department->academicLevel_name }} </option>
                                            @foreach ($academicLevel as $key=>$item )
                                                <option value="{{ $item->id}}" >{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">المرحلة الدراسية</label>
                                    <div class="col-md-10">
                                        <select class="select form-control" id="stage_level_id" name="stage_level_id">
                                            <option value="{{ $department->stage_level_id }}" {{ ( $department->stage_level_id == $department->stage_level_id) ? 'selected' : '' }}>{{ $department->stageLevel->name }} </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"> صورة </label>
                                    <div class="col-md-10">
                                        <input class="form-control" id="image" type="file" name="icon">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"></label>
                                    <div class="col-md-10">
                                        <button type="submit" class="btn btn-primary submit-btn">حفظ</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
        
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
            }
            else
            {
                $box.prop("checked", false);
            }
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
