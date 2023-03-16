<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Arms;
use App\Models\Student;

class ClassesController extends Controller
{
    /**
     * Get the add class page
     */
    public function index(){
        $classes = Classes::with('arms')->get();
        return inertia('Classes/addClass',compact('classes'));
    }

    /**
     * create classes
     */
    public function create(Request $request){
       $request->validate([
           'classname' => 'required',
           'section' => 'required'
       ]);

       $class = new Classes;
       $class->class_name = $request->classname;
       $class->teacher_incharge = $request->class_teacher;
       $class->capacity = $request->capacity;
       $class->section = $request->section;
       $class->save();
       return redirect()->back();
    }

    /**
     * Get all classes
     */
    public function Classes(){
        $classes = Classes::with('arms')->paginate(20);
        return inertia('Classes/classes',compact('classes'));
    }

    /**
     * save arms
     */
    public function saveArms(Request $request){
        $arms = $request->arms;
        $arms_arr = [];
        foreach($arms as $arm){
            array_push($arms_arr,[
                'arm_name'=>$arm,
                'classes_id'=>$request->class_id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                ]);
        }
        if(count($request->old_arms) > 0){
            Arms::destroy($request->old_arms);
        }
        Arms::insert($arms_arr);
        return ['success'=>true];
    }

    /**
     * Edit Classes
     */
    public function getEditClasses(Request $request){
        $classes = Classes::with('arms')->get();
        $singleclass = Classes::find($request->id);
        return inertia('Classes/editClass',compact('classes','singleclass'));
    }

    public function editClasses(Request $request){
        $request->validate([
            'class_name' => 'required',
            'section' => 'required',
        ]);
        $class = Classes::find($request->id);
        $class->class_name = $request->class_name;
        $class->teacher_incharge = $request->teacher_incharge;
        $class->capacity = $request->capacity;
        $class->section = $request->section;
        $class->save();
        //Classes::where('id',$request->id)->update($request->all());
        return redirect('/classes');
    }

    /**
     * delete classes
     */
    public function deleteClasses(Request $request){
        Classes::find($request->id)->delete();
        return ['success'=>true];
    }

    /**
     * Get the class arm
     */
    public function getArms(Request $request){
       $arms = Classes::with('arms')->where('class_name',$request->class_name)->first();
        return response()->json($arms->arms);
    }

    /**
     * Get the class student's page
     */
    public function getStudentsClass(Request $request){
        if($request->arm){
            $students = Student::where('grade',$request->class)->where('arm',$request->arm)->paginate(25)->withQueryString();
        }else{
            $students = Student::where('grade',$request->class)->paginate(25)->withQueryString();
        }
        $page= 0;
      
        if(request()->page > 1){
            $page = $students->firstItem()-1;
        }
        $grade=$request->class;
        $arm = $request->arm? $request->arm: "";
        return inertia('Classes/students',compact('students','grade','page','arm'));
    }
    
}
