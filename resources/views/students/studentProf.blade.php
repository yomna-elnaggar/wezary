@extends('layouts.master')
@section('content')
    @section('style')
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" >
    <!-- checkbox style -->
    <link rel="stylesheet" href="{{ URL::to('assets/css/checkbox-style.css') }}">
    @endsection
    <!-- Page Wrapper -->	
	<!-- Page Wrapper -->
	<div class="page-wrapper">
		
		<!-- Page Content -->
		<div class="content container-fluid">
		
			<!-- Page Header -->
			<div class="page-header">
				<div class="row align-items-center">
					<div class="col">
						<h3 class="page-title">الملف الشخصي للطالب</h3>
						<ul class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{route('home')}}">لوحة التحكم</a></li>
							<li class="breadcrumb-item active">{{$student->name}}</li>
						</ul>
					</div>
                    <div class="col-auto float-right ml-auto">
                         <a href="{{ url('all/students/exams/'.$student->id) }}" class="btn add-btn">الامتحانات</a>
                    </div>
				</div>
			</div>
			<!-- /Page Header -->
			
			<div class="row">
				<div class="col-lg-8 col-xl-9">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title m-b-20">الصورة التي تم تحميلها </h5>
							<div class="row">
								<div class="col-md-3 col-sm-4 col-lg-4 col-xl-4">
									<div class="uploaded-box">
										<div class="uploaded-img">
											<img src="{{url($student->image)}}" class="img-fluid" alt="{{$student->image}}">
										</div>
										
									</div>
								</div>
								<div class="col-md-3 col-sm-4 col-lg-4 col-xl-4">
									<div class="uploaded-box">
										<div class="uploaded-img">
											<img src="{{url($student->pic_identityF)}}" class="img-fluid" alt="{{$student->pic_identityF}}">
										</div>
										
									</div>
								</div>
								<div class="col-md-3 col-sm-4 col-lg-4 col-xl-4">
									<div class="uploaded-box">
										<div class="uploaded-img">
											<img src="{{url($student->pic_identityB)}}" class="img-fluid" alt="{{$student->pic_identityB}}">
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="project-task">
						<ul class="nav nav-tabs nav-tabs-top nav-justified mb-0">
							<li class="nav-item"><a class="nav-link active" href="#all_tasks" data-toggle="tab" aria-expanded="true"> الدورات التي انضم اليها الطالب</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane show active" id="all_tasks">
								<div class="task-wrapper">
									<div class="task-list-container">
										<div class="table-responsive">
											<table class="table table-nowrap">
												<thead>
													<tr>
														<th>اسم الدورة</th>
														<th>اسم المعلم</th>
														<th>أحرز تقدم</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($courses as $item)
													<tr>
														<td>{{$item->name}}</td>
														<td>{{$item->teacher->name}}</td>
														<td><p class="m-b-5">progress <span class="text-success float-right">{{$item->percentage}}%</span></p>
															<div class="progress progress-xs mb-0">
																<div class="progress-bar bg-success" role="progressbar" data-toggle="tooltip" title="{{$item->percentage}}" style="width: {{$item->percentage}}%"></div>
															</div></td>
													</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="pending_tasks"></div>
							<div class="tab-pane" id="completed_tasks"></div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-xl-3">
					<div class="card">
						<div class="card-body">
							<h6 class="card-title m-b-15">تفاصيل الطالب</h6>
							<table class="table table-striped table-border">
								<tbody>
									<tr>
										<td>رقم الهاتف:</td>
										<td class="text-right">{{$student->phone_number}}</td>
									</tr>
									<tr>
										<td>رقم الوالد :</td>
										<td class="text-right">{{$student->parent_phone}}</td>
									</tr>
									<tr>
										<td>كود الطالب:</td>
										<td class="text-right">{{$student->special_code}}</td>
									</tr>
									<tr>
										<td>المستوي الدراسي:</td>
										<td class="text-right">{{$student->academicLevel_name}}</td>
									</tr>
									<tr>
										<td>المرحلة الدراسية:</td>
										<td class="text-right">{{$student->stageLevel_name}}</td>
									</tr>
									<tr>
										<td>الجنس:</td>
										<td class="text-right">{{$student->gender}}</td>
									</tr>
									<tr>
										<td>تاريخ الميلاد:</td>
										<td class="text-right">{{$student->birth_date}}</td>
									</tr>
									
								</tbody>
							</table>
						</div>
					</div>
					
				</div>
			</div>
		</div>
		<!-- /Page Content -->
	</div>
	<!-- /Page Wrapper -->
		
	
@endsection
		

        
      