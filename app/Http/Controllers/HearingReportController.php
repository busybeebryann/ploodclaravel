<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HearingReport;


class HearingReportController extends Controller
{
    //
    public function index() {
      
        $isActive = checkActiveSession();

       if ($isActive ) {

        $hearing = getAllHearingReports();

        dd($hearing);

        return view('hearing.create')->with('hearing',$hearing);

       } else  {
           return redirect('/home');
       }
    }

    public function create() {



    }

    public function store(Request $request) {
        
        return view('');
    }


    public function update(Request $requestid) {


        return view('');

    }

    public function destroy($id) {


        return view('');

    }

    public function download ($id) {

        return view('');
        
    }
        

}
