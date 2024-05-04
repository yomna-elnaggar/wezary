@extends('layouts.master')
@section('content')
    <?php  
        $hour   = date ("G");
        $minute = date ("i");
        $second = date ("s");
        $msg = " Today is " . date ("l, M. d, Y.");

        if ($hour == 00 && $hour <= 9 && $minute <= 59 && $second <= 59) {
            $greet = "صباح الخير,";
        } else if ($hour >= 10 && $hour <= 11 && $minute <= 59 && $second <= 59) {
            $greet = "يوم جيد,";
        } else if ($hour >= 12 && $hour <= 15 && $minute <= 59 && $second <= 59) {
            $greet = "مساء الخير,";
        } else if ($hour >= 16 && $hour <= 23 && $minute <= 59 && $second <= 59) {
            $greet = "مساء الخير,";
        } else {
            $greet = "مرحباً,";
        }
    ?>
    <div class="page-wrapper">
        <!-- Page Content -->
        <div class="content container-fluid">
            <!-- Page Header -->
            <div class="page-header">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="page-title">!{{ Session::get('name') }} {{ $greet }} مرحباً</h3>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item active">لوحة القيادة</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Page Header -->
            <div class="row">
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-cubes"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$courses}}</h3> <span>الدورات</span>
                            </div>
                        </div>
                    </div>
                </div>
              	<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-diamond"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$subjects}}</h3> <span>الدروس</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-usd"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$stubent}}</h3> <span>الطلاب</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                    <div class="card dash-widget">
                        <div class="card-body"> <span class="dash-widget-icon"><i class="fa fa-user"></i></span>
                            <div class="dash-widget-info">
                                <h3>{{$admins}}</h3> <span>المعلمون</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-md-12">
                    <div class="card-group m-b-30">
                        @foreach ($lastFourCourses as $item)
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-3">
                                    <div> <span class="d-block">{{$item->name}}</span> </div>
                                    
                                </div>
                              	<h6 class="mb-3">  {{$item->subjects->count()}}  :عدد الدروس</h6>
                                <p class="mb-0">  {{$item->teacher->name}}: المعلم</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            {{-- message --}}
            {!! Toastr::message() !!}
            <div class="row">
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">المعلمون</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>رقم الهاتف</th>
                                            <th>القسم</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lastFourAdmins as $lastAdmin)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#" class="avatar"><img alt="" src="{{url($lastAdmin->image)}}"></a>
                                                    <a href="{{ url('teachers/profile/'.$lastAdmin->id)}}">{{$lastAdmin->name}} </a>
                                                </h2>
                                            </td>
                                            <td>{{$lastAdmin->phone_number}}</td>
                                            <td>{{$lastAdmin->department}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer"> <a href="{{route('all/teachers/card')}}">عرض جميع المعلمين</a> </div>
                    </div>
                </div>
                <div class="col-md-6 d-flex">
                    <div class="card card-table flex-fill">
                        <div class="card-header">
                            <h3 class="card-title mb-0">الطلاب</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table custom-table mb-0">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>رقم الهاتف</th>
                                            <th>رقم الهاتف الوالد </th>
                                            <th>المستوي الدراسي</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lastFourUsers as $lastUser)
                                        <tr>
                                            <td>
                                                <h2 class="table-avatar">
                                                    <a href="#" class="avatar"><img alt="" src="{{url($lastUser->image)}}"></a>
                                                    <a href="{{ url('all/students/profile/'.$lastUser->id)}}">{{$lastUser->name}} </a>
                                                </h2>
                                            </td>
                                            <td>{{$lastUser->phone_number}}</td>
                                            <td>{{$lastUser->parent_phone}}</td>
                                            <td> {{$lastUser->academicLevel->name}},<small>{{$lastUser->stageLevel->name}}</small></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer"> <a href="{{route('all/students')}}">عرض جميع الطلاب</a> </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Content -->
    </div>
@endsection