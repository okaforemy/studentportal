<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Student;

class ResultController extends Controller
{
    public function index(Request $request){
        if($request->arm){
            $students = Student::with('subjects')->where('grade',$request->grade)->where('arm',$request->arm)->get();
        }else{
            $students = Student::with('subjects')->where('grade',$request->grade)->get();
        }
        return inertia('Students/preNurseryMidtermResult', compact('students'));
    }

    public function holidayAssessment(){
        if($request->arm){
            $students = Student::with('subjects')->where('grade',$request->grade)->where('arm',$request->arm)->get();
        }else{
            $students = Student::with('subjects')->where('grade',$request->grade)->get();
        }

        return inertia('Students/holidayassessment', compact('students'));
    }
    
}
