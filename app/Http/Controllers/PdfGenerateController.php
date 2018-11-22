<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use PDF;

class PdfGenerateController extends Controller
{
    
     public function pdfview(Request $request)
     {
         //$users = DB::table("users")->get();
         //view()->share('users',$users);
         if($request->has('download')){
             // Set extra option
             PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
             // pass view file
             $pdf = PDF::loadView('reports.pdfview');
             // download pdf
             return $pdf->download('pdfview.pdf');
         }
         return view('reports.pdfview');
     }


     public function downloadPDF()
     {
         $pdf = PDF::loadView('pdfview');
         return $pdf->download('invoice.pdf');
     }
}
