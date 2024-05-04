<?php

namespace App\Http\Controllers\dashboard;

use DB;
use PDF;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use App\Models\Admin;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    // main dashboard
    public function index()
    {
        $stubent = DB::table('users')->count();
        $courses= DB::table('courses')->count();
        $subjects= DB::table('subjects')->count();
        $admins= DB::table('admins')->count();
      	$lastFourCourses = Course::orderBy('id', 'desc')->take(4)->get();
        $lastFourAdmins = Admin::orderBy('id', 'desc')->take(4)->get();
      	$lastFourUsers = User::orderBy('id', 'desc')->whereNotNull('academic_level_id')->with(['academicLevel','stageLevel'])->take(4)->get();
        return view('dashboard.dashboard',compact('stubent','courses','subjects','admins','lastFourCourses','lastFourAdmins','lastFourUsers'));
    }
    // employee dashboard
    public function emDashboard()
    {
        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();
        return view('dashboard.emdashboard',compact('todayDate'));
    }

    // public function generatePDF(Request $request)
    // {
    //     // $data = ['title' => 'Welcome to ItSolutionStuff.com'];
    //     // $pdf = PDF::loadView('payroll.salaryview', $data);
    //     // return $pdf->download('text.pdf');
    //     // selecting PDF view
    //     $pdf = PDF::loadView('payroll.salaryview');
    //     // download pdf file
    //     return $pdf->download('pdfview.pdf');
    // }

}
