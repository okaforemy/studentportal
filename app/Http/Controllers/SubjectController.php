<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Subjects;
use App\models\Student;
use App\Models\StudentSubjects;
use App\Models\Classes;
use App\Models\Arms;

class SubjectController extends Controller
{
    /**
     * The assign subject page
     */
    public function index(){
        $sections = Section::all();
        $latestsubjects = Subjects::latest()->paginate(10);
        $page= 0;
        if(request()->page > 1){
            $page = 10 * (request()->page - 1);
        }
       
        return inertia('Subjects/addSubjects',compact('sections','latestsubjects','page'));
    }

    /**
     * Add subjects
     */
    public function AddSubject(Request $request){
     
        $sj = array();
        $subjects = $request->subjects;
        $allsubjects = Subjects::get();
        $sections = $request->sections;
       
        //check if the subjects already exist
        foreach($subjects as $key => $sub){
           $found = $allsubjects->where('subject',$sub)->where('section',$sections[0]['name'])->first();
           if($found){
               unset($subjects[$key]);

           }
        }
        if(empty($subjects)){
            return false;
        }
        
        foreach($sections as $key=>$value){
            foreach($subjects as $subj){
                $myarr = [
                    'subject'=>$subj,
                    'section' =>$value['name'],
                    'category' => $request->category,
                    'created_at'=>\Carbon\Carbon::now(),
                    'updated_at'=>\Carbon\Carbon::now(),
                ];
                array_push($sj, $myarr);
            }
        }

        $subj = new Subjects();
        $subj->insert($sj);
        
        return $sj;
    }

    /**
     * Get the list of subjects for a selected section
     */
    public function getAssignSubject(Request $request){
        $subjects = Subjects::where('section',$request->section)->get();
        //get the selected subjects from the database based on the arm or the class
        if($request->arm){
            $selected_subj = Arms::where('arm_name',$request->arm)->pluck('subjects')[0];
            $student_count = Student::where('grade',$request->grade)->where('arm',$request->arm)->count();
        }else{
            $selected_subj = Classes::where('class_name',$request->grade)->pluck('subjects')[0];
            $student_count = Student::where('grade',$request->grade)->count();
        }
     
        if($student_count == 0){
            return redirect()->route('get-addstudents');
        }

        $selected_subj = (array)json_decode($selected_subj);
        $grade = $request->grade;
        $arm = $request->arm;
        if($subjects->count() <= 0){
          $selected_subj = [];
        }else{
            //ensures that both selected_subj and subjects values exist and remove the ones that do not exist
            foreach($selected_subj as $key => $subj){
                dd($selected_subj);
                $found = $subjects->where('subject',$subj->subject)->where('section',$request->section)->count();
                if($found == 0){
                    unset($selected_subj[$key]);
                }
            }
        }
        
        return inertia('Subjects/assignSubjects', compact('subjects','grade','arm','selected_subj','student_count'));
    }

    /**
     * Assigns subject to students
     */
    public function assignSubjects(Request $request){
        $subjects_id = collect($request->all()['subjects'])->pluck('id');
        if($request->arm){
          $students = Student::where('grade',$request->grade)->where('arm',$request->arm)->get();
        }else{
           $students = Student::where('grade',$request->grade)->get();
        }
      
        foreach($students as $key=>$student){
           $student->subjects()->sync($subjects_id);
        }

        if($request->arm){
            $arm = Arms::where('arm_name',$request->arm)->first();
            $arm->subjects = json_encode($request->subjects);
            $arm->save();
        }else{
            $class = Classes::where('class_name',$request->grade)->first();
            $class->subjects = json_encode($request->subjects);
            $class->save();
        }

        $edited=true;
       return redirect()->route('classes')->with(['edited'=>$edited]);
    }

    /**
     * Delete subject
     */
    public function deleteSubject(Request $request){
        $subjects = Subjects::find($request->id);
        $subjects->student()->detach();
        $subjects->delete();
        return true;
    }
}

