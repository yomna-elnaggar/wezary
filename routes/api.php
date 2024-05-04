<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\HomeController;
use App\Http\Controllers\Api\userAuth\LoginController;
use App\Http\Controllers\Api\userAuth\LogoutController;
use App\Http\Controllers\Api\userAuth\RegisterController;
use App\Http\Controllers\dashboard\AdvertisementController;
use App\Http\Controllers\Api\userAuth\ForgotPasswordController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\FavouriteCourseController;
use App\Http\Controllers\Api\userAuth\ProfileController;
use App\Http\Controllers\Api\userAuth\PasswordController;
use App\Http\Controllers\dashboard\AboutWezaryController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\dashboard\ExamController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

    // ---------------------------- user authentication ---------------------------//
    Route::post('register', [RegisterController::class,'register']);
    Route::post('login', [LoginController::class,'login']);
    Route::post('forgot-password',[ForgotPasswordController::class,'sendVerificationCode']);
    Route::post('verificationCode', [RegisterController::class,'verificationCode']);
    Route::post('change-password',[PasswordController::class,'changePassword']);
    Route::post('verify-phone', [PhoneVerificationController::class , 'verify']);

    // ---------------------------- user academicLevels ---------------------------//
        Route::get('academicLevels',[UserController::class,'academicLevel']);
        Route::get('stageLevels',[UserController::class,'stageLevel']);
	// ----------------------------  TermsConditions ---------------------------//
 	Route::get('TermsConditions',[AboutWezaryController::class,'TermsConditions']);

    Route::middleware('auth:sanctum')->group(function() {
        // ---------------------------- user authentication ---------------------------//
        Route::post('completeRegistration', [RegisterController::class,'completeRegistration']);
        Route::post('resetPassword', [ForgotPasswordController::class ,'resetPassword']);
        Route::post('logout',[LogoutController::class,'logout']);
		// ---------------------------- user profile ---------------------------//
        Route::get('/profile',[ProfileController::class,'profile']);
        Route::post('updateProfile', [ProfileController::class,'update']);
        Route::post('destroy', [ProfileController::class, 'destroy']);
        Route::post('change-password',[PasswordController::class,'changePassword']);
        // ---------------------------- allAdvertisement---------------------------//
        Route::get('allAdvertisement',[AdvertisementController::class,'allAdvertisement']);
        Route::get('advertisement',[AdvertisementController::class,'oneAdvertisement']);

        // ---------------------------- Home---------------------------//
        Route::get('recently',[HomeController::class,'recentlyCourse']);
        Route::get('recentlyCourses',[HomeController::class,'recentlyCourses']);
        Route::get('departments',[HomeController::class,'departments']);
        Route::get('teachers',[HomeController::class,'teachers']);
		// ---------------------------- departmentCourses---------------------------//
        Route::get('departmentCourses',[DepartmentController::class,'departmentCourses']);
      
      	// ---------------------------- TeacherDetails---------------------------//
        Route::get('TeacherDetails',[TeacherController::class,'teacher']);
     	// ---------------------------- CourseDetails---------------------------//
        Route::get('CourseDetails',[CourseController::class,'Course']);
        Route::post('CourseSubscription',[CourseController::class,'CourseSubscription']);
      	Route::get('MyCourses',[CourseController::class,'MyCourses']);	
      	Route::post('addToFavorites', [FavouriteCourseController::class,'addToFavorites']);
        Route::post('removeFromFavorites', [FavouriteCourseController::class,'removeFromFavorites']);
        Route::get('myFavoriteCourses',[FavouriteCourseController::class,'myFavoriteCourses']);
      	// ---------------------------- UserAttachSubject---------------------------//
        Route::get('UserAttachSubject',[SubjectController::class,'UserAttachSubject']);
      	Route::post('AttendingMin',[SubjectController::class,'AttendingMin']);
     	// ---------------------------- AboutUs---------------------------//
        Route::get('AboutUs',[AboutWezaryController::class,'AboutUs']);
       
        Route::get('Communication',[AboutWezaryController::class,'GetCommunication']);
      	// ---------------------------- ApiExam---------------------------//
      	Route::get('Exam', [ExamController::class,'ApiExam']);
      
      ///
      Route::get('notifications', [NotificationController::class,'index']);			
  	Route::get('sendNotification', [NotificationController::class,'sendNotification']);
    });

