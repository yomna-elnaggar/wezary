
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="menu-title">
                    <span>رئيسية</span>
                </li>
                <li class="{{set_active(['home','em/dashboard'])}} submenu">
                    <a href="#" class="{{ set_active(['home','em/dashboard']) ? 'noti-dot' : '' }}">
                        <i class="la la-dashboard"></i>
                        <span> لوحة تحكم</span> <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                           @if(Auth::guard('admin')->user()->hasRole('Admin'))
                           <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">لوحة تحكم المشرف</a></li>
                            @else
                            <li><a class="{{set_active(['home'])}}" href="{{ route('home') }}">لوحة تحكم المعلم </a></li>
                            @endif

                    </ul>
                </li>
               
                    <li class="menu-title"> <span>الطلاب</span> </li>
                    <li class="{{set_active(['all/students'])}} submenu">
                        <a href="#" class="{{ set_active(['all/students']) ? 'noti-dot' : '' }}">
                            <i class="la la-user-secret"></i> <span> الطلاب</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['all/students'])}}" href="{{ route('all/students') }}">كل الطلاب</a></li>
                        </ul>
                    </li>
                
                    <li class="menu-title"> <span>المعلمين</span> </li>
                    <li class="{{set_active(['all/teachers/list','all/teachers/list','all/teachers/card','form/holidays/new','form/leaves/new',
                        'form/leavesemployee/new','form/leavesettings/page','attendance/page',
                        'attendance/employee/page','form/departments/page','form/designations/page',
                        'form/timesheet/page','form/shiftscheduling/page','form/overtime/page'])}} submenu">
                        <a href="#" class="{{ set_active(['all/teachers/list','all/teachers/card','form/holidays/new','form/leaves/new',
                        'form/leavesteachers/new','form/leavesettings/page','attendance/page',
                        'attendance/teachers/page','form/departments/page','form/designations/page',
                        'form/timesheet/page','form/shiftscheduling/page','form/overtime/page']) ? 'noti-dot' : '' }}">
                            <i class="la la-user"></i> <span> المعلمين</span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            <li><a class="{{set_active(['all/teachers/list','all/teachers/card'])}} {{ request()->is('all/teachers/view/edit/*','teachers/profile/*') ? 'active' : '' }}" href="{{ route('all/teachers/card') }}">جميع المعلمين</a></li>
                        
                        </ul>
                    </li>

                    <li class="menu-title"> <span> المستوي الدراسي</span> </li>
                    <li class="{{set_active(['form/stageLevel/page','form/academicLevel/page',
                        'all/department/list'])}} submenu">
                        <a href="#" class="{{ set_active(['form/academicLevel/page','form/stageLevel/page',
                        'all/department/list']) ? 'noti-dot' : '' }}">
                            <i class="la la-hdd"></i> <span>  المستوي الدراسي  </span> <span class="menu-arrow"></span>
                        </a>
                        <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                            {{-- <li><a class="{{set_active(['form/academicLevel/page'])}} {{ request()->is('form/academicLevel/page','teachers/profile/*') ? 'active' : '' }}" href="{{ route('all/teachers/card') }}">جميع المعلمين</a></li> --}}
                            <li><a class="{{set_active(['form/academicLevel/page'])}}" href="{{ route('form/academicLevel/page') }}"> المستوي الدراسي</a></li>
                            <li><a class="{{set_active(['form/stageLevel/page'])}}" href="{{ route('form/stageLevel/page') }}"> المرحلة الدراسية</a></li>
                            <li><a class="{{set_active(['all/department/list'])}}" href="{{ route('all/department/list') }}">القسم</a></li>
                        </ul>
        
                <li class="menu-title"> <span>الدورات</span> </li>
                <li class="{{set_active(['all/courses/card','form/estimates/page','payments','expenses/page'])}} submenu">
                    <a href="#" class="{{ set_active(['all/courses/card','form/estimates/page','payments','expenses/page']) ? 'noti-dot' : '' }}">
                        <i class="la la-files-o"></i>
                        <span> الدورات </span> 
                        <span class="menu-arrow"></span>
                    </a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/courses/card'])}} }}{{ request()->is('all/courses/*','courses/profile/{courses_id}') ? 'active' : '' }}" href="{{ route('all/courses/card') }}">الدورات</a></li>
                        {{--i><a class="{{set_active(['payments'])}}" href="{{ route('payments') }}">Payments</a></li>
                        <li><a class="{{set_active(['expenses/page'])}}" href="{{ route('expenses/page') }}">Expenses</a></li>--}}
                    </ul>
                </li>
     			 @if (Auth::guard('admin')->user()->can('access any'))
                <li class="menu-title"> <span>إعلان</span> </li>
                <li class="{{set_active(['all/advertisement'])}} submenu">
                    <a href="#" class="{{ set_active(['all/advertisement']) ? 'noti-dot' : '' }}"><i class="la la-graduation-cap"></i>
                    <span> إعلان </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/advertisement'])}}" href="{{ route('all/advertisement') }}"> إعلان </a></li>
                    </ul>
                </li>
      			
      			<li class="menu-title"> <span>حول وزاري</span> </li>
                <li class="{{set_active(['all/AboutWezary','all/Communication'])}} submenu">
                    <a href="#" class="{{ set_active(['all/AboutWezary','all/Communication']) ? 'noti-dot' : '' }}"><i class="la la-briefcase"></i>
                    <span> حول وزاري </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/AboutWezary'])}}" href="{{ route('all/AboutWezary') }}"> حول وزاري </a></li>
                      	<li><a class="{{set_active(['all/Communication'])}}" href="{{ route('all/Communication') }}"> تواصل </a></li>
                    </ul>
                </li>
      
      			<li class="menu-title"> <span>إشعار</span> </li>
                	<li class="{{set_active(['all/Notification'])}} submenu">
                    <a href="#" class="{{ set_active(['all/Notification']) ? 'noti-dot' : '' }}"><i class="la la-briefcase"></i>
                    <span> إشعار </span> <span class="menu-arrow"></span></a>
                    <ul style="{{ request()->is('/*') ? 'display: block;' : 'display: none;' }}">
                        <li><a class="{{set_active(['all/Notification'])}}" href="{{ route('all/Notification') }}"> إشعار</a></li>
                    </ul>
                </li>
      			@endif
            
                
            </ul>
        </div>
    </div>
</div>
<!-- /Sidebar -->