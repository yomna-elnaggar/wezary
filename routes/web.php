<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\dashboard\HomeController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\dashboard\AdminController;
use App\Http\Controllers\dashboard\CourseController;
use App\Http\Controllers\dashboard\SubjectController;
use App\Http\Controllers\dashboard\TeacherController;
use App\Http\Controllers\dashboard\Auth\LoginController;
use App\Http\Controllers\dashboard\DepartmentController;
use App\Http\Controllers\dashboard\StageLevelController;
use App\Http\Controllers\dashboard\AcademicLevelController;
use App\Http\Controllers\dashboard\AdvertisementController;
use App\Http\Controllers\dashboard\Auth\RegisterController;
use App\Http\Controllers\dashboard\StudentsController;
use App\Http\Controllers\dashboard\AboutWezaryController;
use App\Http\Controllers\dashboard\Auth\ForgotPasswordController;
use App\Http\Controllers\dashboard\Auth\ResetPasswordController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\dashboard\ExamController;
use App\Http\Controllers\dashboard\PDFController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** for side bar menu active */
function set_active($route) {
    if (is_array($route )){
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active' : '';
}

Route::get('/', function () {
    return view('auth.login');
});

    // Route::group(['middleware'=>'auth'],function()
    // {
    // Route::get('home',function()
    // {
    //     return view('home');
    // });
    // Route::get('home',function()
    // {
    //     return view('home');
    // });
    // });

//Auth::routes();



    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/login', 'login')->name('login');
        Route::post('/login', 'authenticate');
    });

    // ------------------------------ register ----------------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'index')->name('register');
        Route::post('/register','register')->name('register');   
        Route::get('/logout', 'logout')->name('logout'); 
    });

    // ----------------------------- forget password ----------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'getEmail')->name('forget-password');
        Route::post('forget-password', 'postEmail')->name('forget-password');    
    });

    // ----------------------------- reset password -----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::post('reset-password', 'updatePassword');    
    });

    // ----------------------------- main dashboard ------------------------------//
    Route::controller(HomeController::class)->group(function () {
        Route::get('/home', 'index')->name('home');
        Route::get('em/dashboard', 'emDashboard')->name('em/dashboard');
    });

    // ---------------------------- form Admin ---------------------------//
    Route::controller(AdminController::class)->group(function () {
        Route::get('profile_user', 'profile')->middleware('auth:admin')->name('profile_user');
        Route::post('profile/information/save', 'profileInformation')->name('profile/information/save');
        Route::get('change/password', 'changePasswordView')->middleware('auth:admin')->name('change/password');
        Route::post('change/password/db', 'changePasswordDB')->name('change/password/db');
    });

    // ---------------------------- form Teachers ---------------------------//
    Route::controller(TeacherController::class)->group(function () {
        Route::get('all/teachers/card', 'cardAllTeachers')->middleware('auth:admin')->name('all/teachers/card');
        Route::get('all/teachers/list', 'listAllTeachers')->middleware('auth:admin')->name('all/teachers/list');
        Route::post('all/teachers/save', 'saveRecord')->middleware('auth:admin')->name('all/teachers/save');
        Route::get('all/teachers/view/edit/{teachers_id}', 'viewRecord');
        Route::post('all/teachers/update', 'updateRecord')->middleware('auth:admin')->name('all/teachers/update');
        Route::get('all/teachers/delete/{teachers_id}', 'deleteRecord')->middleware('auth:admin');
        Route::post('all/teachers/search', 'teachersSearch')->name('all/teachers/search');
        Route::post('all/teachers/list/search', 'teachersListSearch')->name('all/teachers/list/search');
        Route::get('teachers/profile/{teachers_id}', 'profileTeachers')->middleware('auth:admin')->name('teachers/profile');
      	Route::get('all/teachers/active/{Admin_id}', 'active')->middleware('auth:admin');
       
    });

    // ---------------------------- form AcademicLevel ---------------------------//
    Route::controller(AcademicLevelController::class)->group(function () {
        Route::get('form/academicLevel/page', 'index')->middleware('auth:admin')->name('form/academicLevel/page');    
        Route::post('form/academicLevel/save', 'saveRecordAcademicLevel')->middleware('auth:admin')->name('form/academicLevel/save');    
        Route::post('form/academicLevel/update', 'updateRecordAcademicLevel')->middleware('auth:admin')->name('form/academicLevel/update');    
        Route::post('form/academicLevel/delete', 'deleteRecordAcademicLevel')->middleware('auth:admin')->name('form/academicLevel/delete');  
        
    });
   
    // ---------------------------- form StageLevel ---------------------------//
    Route::controller(StageLevelController::class)->group(function () {
        Route::get('form/stageLevel/page', 'stageLevelIndex')->middleware('auth:admin')->name('form/stageLevel/page');    
        Route::post('form/stageLevel/save', 'saveRecordStageLevel')->middleware('auth:admin')->name('form/stageLevel/save');    
        Route::post('form/stageLevel/update', 'updateRecordStageLevel')->middleware('auth:admin')->name('form/stageLevel/update');    
        Route::post('form/stageLevel/delete', 'deleteRecordStageLevel')->middleware('auth:admin')->name('form/stageLevel/delete');
    });
    
    // ---------------------------- form departments ---------------------------//
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('all/department/list', 'listAllDepartments')->middleware('auth:admin')->name('all/department/list');
        Route::get('stageLevel/{academic_level_id}','getstageLevel');
        Route::post('all/department/save', 'saveRecord')->middleware('auth:admin')->name('all/department/save');
        Route::get('all/department/view/edit/{department_id}', 'viewRecord');
        Route::post('all/department/update', 'updateRecord')->middleware('auth:admin')->name('all/department/update');
        Route::get('all/department/delete/{department_id}', 'deleteRecord')->middleware('auth:admin');
        Route::post('all/department/list/search', 'departmentListSearch')->name('all/department/list/search');
    });

    // ---------------------------- form courses ---------------------------//
    Route::controller(CourseController::class)->group(function () {
        Route::get('all/courses/card', 'cardAllCourses')->middleware('auth:admin')->name('all/courses/card');
        Route::post('all/courses/save', 'saveRecord')->middleware('auth:admin')->name('all/courses/save');
        Route::get('all/courses/view/edit/{courses_id}', 'viewRecord');
        Route::post('all/courses/update', 'updateRecord')->middleware('auth:admin')->name('all/courses/update');
        Route::post('all/courses/delete', 'deleteRecord')->middleware('auth:admin');
        Route::post('all/courses/search', 'coursesSearch')->name('all/courses/search');
        Route::get('courses/profile/{courses_id}', 'profileCourses')->middleware('auth:admin');
        Route::post('all/courses/approv/{courses_id}', 'approv')->middleware('auth:admin');
      	Route::post('all/save-course-code', 'saveCourseCode')->name('all/save-course-code');
    });

    // ---------------------------- form Subject ---------------------------//
    Route::controller(SubjectController::class)->group(function () {
        Route::get('all/subject/card', 'cardAllSubject')->middleware('auth:admin')->name('all/subject/card');
        Route::post('all/subject/save', 'saveRecord')->middleware('auth:admin')->name('all/subject/save');
        Route::get('all/subject/view/edit/{subject_id}', 'viewRecord');
        Route::post('all/subject/update', 'updateRecord')->middleware('auth:admin')->name('all/subject/update');
        Route::post('all/subject/delete', 'deleteRecord')->middleware('auth:admin');
    });

    // ----------------------------- AdvertisementController --------------------------------//
    Route::controller(AdvertisementController::class)->group(function () {
        Route::get('all/advertisement','advertisement')->middleware('auth:admin')->name('all/advertisement');
        Route::post('all/advertisement/save', 'saveRecord')->middleware('auth:admin')->name('all/advertisement/save');
        Route::post('all/advertisement/update', 'updateRecord')->middleware('auth:admin')->name('all/advertisement/update');
        Route::post('all/advertisement/delete', 'deleteRecord')->middleware('auth:admin')->name('all/advertisement/delete');    
    });

 	// -----------------------------Student-------------------------------------//
    Route::controller(StudentsController::class)->group(function () {
        Route::get('all/students', 'students')->middleware('auth:admin')->name('all/students');//////////////للطلاب 
        Route::post('all/students/delete', 'deleteRecord')->middleware('auth:admin')->name('all/students/delete');
        Route::post('all/students/search', 'studentsSearch')->middleware('auth:admin')->name('all/students/search');
        Route::get('all/students/profile/{students_id}', 'profileStudent')->middleware('auth:admin');
      	Route::get('all/students/active/{students_id}', 'toggel')->middleware('auth:admin');
      	Route::post('all/students/twoDiv/', 'twoDivdivse')->middleware('auth:admin')->name('all/students/twoDiv');

    });


    // -----------------------------exam-------------------------------------//
    Route::controller(ExamController::class)->group(function () {
      Route::get('all/students/exams/{students_id}', 'exams')->middleware('auth:admin');//////////////للطلاب 
      Route::post('all/students/exams/save', 'saveRecord')->middleware('auth:admin')->name('all/students/exams/save');
      Route::post('all/students/exams/delete', 'deleteRecord')->middleware('auth:admin')->name('all/students/exams/delete');
      Route::get('exampdf/{students_id}', 'generatePDF');

    
    });

	// ----------------------------- AboutWezaryController --------------------------------//
    Route::controller(AboutWezaryController::class)->group(function () {
        Route::get('all/AboutWezary','AboutWezary')->middleware('auth:admin')->name('all/AboutWezary');
        Route::post('all/AboutWezary/update', 'updateRecord')->middleware('auth:admin')->name('all/AboutWezary/update'); 
        Route::get('all/Communication','Communication')->middleware('auth:admin')->name('all/Communication');
        Route::post('all/Communication/update', 'updateCommunication')->middleware('auth:admin')->name('all/Communication/update'); 
    });


 	// ----------------------------- Notification --------------------------------//
    Route::get('all/Notification',[NotificationController::class,'Notification'])->middleware('auth:admin')->name('all/Notification');
 	Route::post('all/Notification/saveRecord',[NotificationController::class,'saveRecord'])->middleware('auth:admin')->name('all/Notification/saveRecord');
    
 	Route::get('generate-pdf/{teachers_id}', [PDFController::class, 'generatePDF']);

