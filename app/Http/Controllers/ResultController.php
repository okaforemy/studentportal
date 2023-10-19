<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\HolidayAssessment;
use App\Models\PrimaryExam;

class ResultController extends Controller
{
    public function index(Request $request){
        if($request->section=="nursery"){
            // if($request->arm){
            //     $students = Student::with('subjects')->where('grade',$request->grade)->where('arm',$request->arm)->get();
            // }else{
            //     $students = Student::with('subjects')->where('grade',$request->grade)->get();
            // }
            // return inertia('Students/preNurseryMidtermResult', compact('students'));
        }
        
        if($request->section=="primary"){
            if($request->arm){
                $students = Student::with('subjects')->where('grade',$request->grade)->where('arm',$request->arm)->get();
            }else{
                $students = Student::with('subjects')->where('grade',$request->grade)->get();
            }
            return inertia('Students/primaryMidtermResult', compact('students'));
        }
    }

    public function holidayAssessment(Request $request){
        if($request->arm){
            $students = Student::with(['subjects'=>function($query){
                 $query->where('holiday','=',1);
            },'holidayAssessment'])->where('grade',$request->grade)->where('arm',$request->arm)->get();
//             dd($students);
//             $students->map(function($student){
//                 $holiday=$student->holidayAssessment;
//                 $student->subjects->transform(function($item)use($holiday){
//                     $hol = $holiday->where('subject',$item->subject)->first();
//                     //dd($hol->score);
//                     $item['subject'] = $item->subject;
//                     $item['section'] = $item->section;
//                     $item['category'] = $item->category;
//                     $item['score'] = $hol? $hol->score: '';
//                     return $item;
//                 });
//             });

// dd($students);

        }else{
            $students = Student::with('subjects')->where('grade',$request->grade)->get();
        }
        return inertia('Students/holidayassessment', compact('students'));
    }
    
    public function saveHolidayAssessment(Request $request){
        HolidayAssessment::insert($request->all());
        return response()->json(['success'=>'saved successfully']);
    }

    /**
       * Get the midterm result
       */
      public function getMidTermResult(Request $request){
        $student = Student::with(['holidayAssessment','primaryExam'=>function($query){
             $query->where('session', '2021/2022')->where('term','second term');
        }])->where('id', $request->student_id)->first();
        $exams = PrimaryExam::where('grade',$student->grade)->where('session', '2021/2022')->where('term','second term')->where('arm', $student->arm)->get();
    
        $total = $exams->sum('first_ca');
        $count = $exams->count();
        $percentage = ($total/$count);
        $student['class_avg'] = $percentage;
        return response()->json($student);
      }
}
