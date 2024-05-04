<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Admin;
use PDF;

class PDFController extends Controller
{
     public function generatePDF($teachers_id)
    {
     
       $teacher = Admin::findOrFail($teachers_id);
       $courses =	$teacher->courses;
       
          	//$pdf = App::make('dompdf.wrapper');
    		//$pdf->loadHTML('<h1>Test</h1>');
       $allUsers = collect(); 

       foreach ($courses as $course) {
         $users = $course->users;
         $allUsers = $allUsers->merge($users); 
       }
        $data = [
            'title' => 'تقرير المعلم',
            'date' => date('m/d/Y'),
            'allUsers' => $allUsers,
          	'teacher' =>$teacher
        ];

        
		$pdf = PDF::loadView('pdf', $data);
        $doc = 'report';
        return $pdf->stream($doc . '.pdf');

	//return $pdf->download('report.pdf');
    }
}
