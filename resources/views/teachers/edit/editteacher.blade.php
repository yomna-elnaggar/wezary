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
                        <h3 class="page-title">عرض المعلم</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item active">تعديل المعلم</li>
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
                            <h4 class="card-title mb-0">تعديل المعلم</h4>
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
                            <form action="{{ route('all/teachers/update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" class="form-control" id="id" name="id" value="{{ $teacher->id }}">
                                <input  type="hidden" name='old_image' value="{{$teacher->image}}" >
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">الاسم</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="name" name="name" value="{{ $teacher->name }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">البريد الإلكتروني</label>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ $teacher->email }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">رقم الهاتف المحمول </label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $teacher->phone_number }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"> الصورة </label>
                                    <div class="col-md-10">
                                        <input class="form-control" id="image" type="file" name="image">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">الجنس</label>
                                    <div class="col-md-10">
                                        <select class="select form-control" id="gender" name="gender">
                                            <option value="{{ $teacher->gender }}" >{{ $teacher->gender }} </option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2">القسم</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="department" name="department" value="{{ $teacher->department }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"> كلمة المرور</label>
                                    <div class="col-md-10"> 
                                        <input type="password" class="form-control" id="password" name="password" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-2"> الوصف</label>
                                    <Div class="col-md-10">
                                        <textarea rows="2" class="form-control" id="description" name="description">{{ $teacher->description }}</textarea>
                                    </div>
                                </div>

                                {{-- <div class="form-group row">
                                    <label class="col-form-label col-md-2">Employee Permission</label>
                                    <div class="col-md-10">
                                        <div class="table-responsive m-t-15">
                                            <table class="table table-striped custom-table">
                                                <thead>
                                                    <tr>
                                                        <th>Module Permission</th>
                                                        <th class="text-center">Read</th>
                                                        <th class="text-center">Write</th>
                                                        <th class="text-center">Create</th>
                                                        <th class="text-center">Delete</th>
                                                        <th class="text-center">Import</th>
                                                        <th class="text-center">Export</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $key = 0;
                                                    $key1 = 0;
                                                    ?>
                                                    @foreach ($permission as $items )
                                                    <tr>
                                                        <td>{{ $items->module_permission }}</td>
                                                        <input type="hidden" name="permission[]" value="{{ $items->module_permission }}">
                                                        <input type="hidden" name="id_permission[]" value="{{ $items->id }}">
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox read{{ ++$key }}" id="read" name="read[]" value="Y"{{ $items->read =="Y" ? 'checked' : ''}} >
                                                            <input type="checkbox" class="option-input checkbox read{{ ++$key1 }}" id="read" name="read[]" value="N" {{ $items->read =="N" ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox write{{ ++$key }}" id="write" name="write[]" value="Y" {{ $items->write =="Y" ? 'checked' : ''}}>
                                                            <input type="checkbox" class="option-input checkbox write{{ ++$key1 }}" id="write" name="write[]" value="N" {{ $items->write =="N" ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox create{{ ++$key }}" id="create" name="create[]" value="Y" {{ $items->create =="Y" ? 'checked' : ''}}>
                                                            <input type="checkbox" class="option-input checkbox create{{ ++$key1 }}" id="create" name="create[]" value="N" {{ $items->create =="N" ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox delete{{ ++$key }}" id="delete" name="delete[]" value="Y" {{ $items->delete =="Y" ? 'checked' : ''}}>
                                                            <input type="checkbox" class="option-input checkbox delete{{ ++$key1 }}" id="delete" name="delete[]" value="N" {{ $items->delete =="N" ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox import{{ ++$key }}" id="import" name="import[]" value="Y" {{ $items->import =="Y" ? 'checked' : ''}}>
                                                            <input type="checkbox" class="option-input checkbox import{{ ++$key1 }}" id="import" name="import[]" value="N" {{ $items->import =="N" ? 'checked' : ''}}>
                                                        </td>
                                                        <td class="text-center">
                                                            <input type="checkbox" class="option-input checkbox export{{ ++$key }}" id="export" name="export[]" value="Y" {{ $items->export =="Y" ? 'checked' : ''}}>
                                                            <input type="checkbox" class="option-input checkbox export{{ ++$key1 }}" id="export" name="export[]" value="N" {{ $items->export =="N" ? 'checked' : ''}}>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div> --}}
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
    @endsection

@endsection
