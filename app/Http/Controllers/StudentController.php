<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Classes;
use App\Models\PrimaryExam;
use App\Models\primaryAffective;
use App\Models\attendance;
use App\Models\Subjects;
use App\Models\physicaldevelopment;
use App\Models\secondaryExam;
use App\Models\remark;
use App\Models\PreNurseryExam;
use App\Models\SeniorSecondaryExam;

class StudentController extends Controller
{
    /**
     * Gets the students page
     */
    public function index(){
        $classes = Classes::all();
        return inertia('Students/addStudent', compact('classes'));
    }

    /**
     * Add student's record
     */
    public function addStudent(Request $request){
        $request->validate([
            'surname'=>'required',
            'othernames'=>'required',
            'dob'=>'required',
            'sex'=>'required',
            'student_id'=>'required|unique:students,deleted_at,NULL'
        ]);
        $class = Classes::find($request->grade);

        $request->merge(['fullname'=>$request->surname." ".$request->othernames,'grade'=>$class->class_name,'class_id'=>$request->grade]);
        Student::create($request->all());

        $students = $this->getRecentlyAddedStudent();
   
        return redirect()->route('addstudents',compact('students'));
    }
    
    /**
     * fetch the recently added students
     */
    public function getRecentlyAddedStudent(){
        $students = Student::latest()->get()->take(7);
        return $students;
    }

    /**
     * fetch all students
     */
    public function Students(){
        $students = Student::latest()->paginate(20);
        return inertia('Students/students',compact('students'));
    }

    /**
     * search for student
     */
    public function searchForChildren(Request $request){
        $students = Student::query()
        ->when($request->input('search'), function($query,$search){
            $query->withCount('Parents')->where('fullname','like',"%{$search}%")
            ->orWhere('student_id','like',"%{$search}%");
        })->get();
        
        return $students;
    }

    /**
     * Delete Student
     */
    public function deleteStudent(Request $request){
        Student::find($request->id)->delete();
        return response()->json(['success'=>true]);
    }

    /**
     * Enter student's scores
     */

     public function addStudentScores(Request $request){
   
         if($request->section=="primary" || $request->section == "nursery"){
              //if no class supplied then go to the class page
            if(!$request->grade){
                return redirect('/classes');
            }

            $students = Student::with('subjects')->where('grade',$request->grade)->paginate(20)->withQueryString();
                $page= 0;
            
                //if a student is selected, give me the subject, else give me the first subject
            if(!$request->newpage){
                if(!$request->page){
                        $student = [0];
                        $selectedstudent = 0;
                }else{
                        $student = $students[$request->currentStudent];
                        $selectedstudent=$request->currentStudent;
                }
            }else{
                    $student = $students[0];
                    $selectedstudent = 0;
            }

            $subjects = isset($student->subjects)? $student->subjects : [];
            $grade = $request->grade;
            //if no student is selected return back
            if(!$request->studentid){
                $section = $request->section;
                    return inertia('Students/addstudentscores',compact('students','subjects','student','grade','section'));
            }

            //paginator increment
                if(request()->page > 1){
                    $page = $students->firstItem()-1;
                }
            
                $currentpage = $request->page? $request->page: 1;
               
                $primaryexam = PrimaryExam::where('student_id',$request->studentid)->where('grade',$request->grade)->where('term','second term')->where('session','2021/2022')->get();
            
            $subj_transform = collect($subjects);
            //remove the id from the object
            $subj_transform->map(function($value, $key){
                unset($value->id);
                    return $value;
            });
                //combines the subject and primary exam if primaryexam is not empty
            if(count($primaryexam) > 0){
                    $subjects = $subj_transform->transform(function($item, $key) use ($primaryexam){
                        $found = $primaryexam->where('subject',$item->subject);
                        if(count($found) > 0){
                            return $found->first();
                        }else{
                            return $item;
                        }
                    });
            }

            $section = $request->section;
                return inertia('Students/addstudentscores',compact('students','page','student','grade','currentpage','selectedstudent','subjects','primaryexam','section'));
         }

         //for pre nursery
         if($request->section == 'pre_nursery'){
          
            $students = Student::with('subjects')->where('grade',$request->grade)->paginate(20)->withQueryString();

            $page = 0;
            if(!$request->newpage){
                if(!$request->page){
                        $student = [0];
                        $selectedstudent = 0;
                }else{
                        $student = $students[$request->currentStudent];
                        $selectedstudent=$request->currentStudent;
                }
            }else{
                    $student = $students[0];
                    $selectedstudent = 0;
            }

            if(request()->page > 1){
                $page = $students->firstItem()-1;
            }

            $currentpage = $request->page? $request->page: 1;
            $grade = $request->grade;
            $section = $request->section;

            $subjects = isset($student->subjects)? $student->subjects->groupBy('category') : [];

            if($request->studentid){
                $scores = PreNurseryExam::where('student_id',$request->studentid)->where('session','2020/2021')->where('term','second term')->get();
                $subj_transform = collect($subjects);
              
                //remove the id from the object
                $subj_transform->map(function($value, $key){
                    unset($value->id);
                        return $value;
                });
                    //combines the subject and primary exam if primaryexam is not empty
                if(count($scores) > 0){
                    $categories = $scores->pluck('category');
                    
                        $subjects = $subj_transform->filter(function($item, $key) use ($categories, $scores){
                             if($categories->contains($key)){
                                $val = $item->each(function($item, $key){
                                    return $item;
                                })
                                ->transform(function($item, $key) use ($scores){
                                    $found = $scores->where('subject',$item->subject)->first();
                                    if($found){
                                        $found['pre_nursery_exams_id'] = $found->id;
                                        return $found;
                                    }else{
                                        return $item;
                                    }
                                });
                                return $val;
                             }
                        });

                }
            }
           

            return inertia('Students/addprenurseryscores',compact('students','student','selectedstudent','page','currentpage','grade','section','subjects'));
         }
        
         //for junior secondary 
         if($request->section == "junior_secondary"){ 
         
               $clas = Classes::where('class_name',$request->grade)->where('section',$request->section)->first();
               $subjects = json_decode($clas->subjects);
              if(!$subjects){
                return redirect('/assign-subjects?section='.$request->section.'&grade='.$request->grade);
              }
               $subj = $request->subject? $request->subject: $subjects[0]->subject;
               $studentsubject = Subjects::with('student')->where('subject',$subj)->where('section',$request->section)->first();
        
               $students = $studentsubject->student;
    
           $grade = $request->grade;
           $currentpage = ($request->currentpage== '0' || $request->currentpage)? $request->currentpage: "not";
           $section = $request->section;
           $subject = $studentsubject->subject;
       
          // $subj_transform = collect($subjects);
           $secondaryExam = secondaryExam::where('subject',$request->subject)->where('grade',$request->grade)->where('term','Third term')->where('session','2021/2022')->get();
          
             //combines the subject and secondary exam if secondaryExam is not empty
             if(count($secondaryExam) > 0){
                $students = $students->transform(function($item, $key) use ($secondaryExam){
                    $subj = $secondaryExam->where('student_id',$item->id)->first();
                      $item['first_ca'] = $subj->first_ca;
                      $item['second_ca'] = $subj->second_ca;
                      $item['exam'] = $subj->exam;
                      $item['total'] = $subj->total;
                      $item['remark'] = $subj->remark;
                      $item['subject_id'] = $subj->id;
                      return $item;
                 
                });
               
            }
      
           return inertia('Students/addsecondarystudentscore',compact('students','subject','clas','subjects','currentpage','grade','section'));
         }

         //for senior secondary
         if($request->section == 'senior_secondary'){
            
                    $clas = Classes::where('class_name',$request->grade)->where('section',$request->section)->first();
                    $subjects = json_decode($clas->subjects);
                if(!$subjects){
                    return redirect('/assign-subjects?section='.$request->section.'&grade='.$request->grade);
                }
                    $subj = $request->subject? $request->subject: $subjects[0]->subject;
                    $studentsubject = Subjects::with('student')->where('subject',$subj)->where('section',$request->section)->first();
            
                    $students = $studentsubject->student;
        
                $grade = $request->grade;
                $currentpage = ($request->currentpage== '0' || $request->currentpage)? $request->currentpage: "not";
                $section = $request->section;
                $subject = $studentsubject->subject;
           
                // $subj_transform = collect($subjects);
                $seniorSecondaryExam = SeniorSecondaryExam::where('subject',$request->subject)->where('grade',$request->grade)->where('term','Third term')->where('session','2021/2022')->get();
                //combines the subject and secondary exam if secondaryExam is not empty
                if(count($seniorSecondaryExam) > 0){
                    $students = $students->transform(function($item, $key) use ($seniorSecondaryExam){
                    
                        $subj = $seniorSecondaryExam->where('student_id',$item->id)->first();
                        $item['first_ca'] = $subj->first_ca;
                        $item['second_ca'] = $subj->second_ca;
                        $item['exam'] = $subj->exam;
                        $item['total'] = $subj->total;
                        $item['remark'] = $subj->remark;
                        $item['subject_id'] = $subj->id;
                        return $item;
                    
                    });
                    
                }
    
                return inertia('Students/addseniorsecondarystudentscore',compact('students','subject','clas','subjects','currentpage','grade','section'));
         }
        
     }

     /**
      * Save student's scores
      */
      public function saveScores(Request $request){
          //save the junior secondary exam
         if($request->section == "junior_secondary"){
            $success= secondaryExam::upsert(
               $request->data,
                ['id'],
                ['subject','first_ca','second_ca','exam','total','remark']
            );
            if($success){
                return ['success'=>true];
            }
         }

         //senior secondary
         if($request->section == 'senior_secondary'){
            $success= SeniorSecondaryExam::upsert(
                $request->data,
                 ['id'],
                 ['subject','first_ca','second_ca','exam','total','remark']
             );
             if($success){
                 return ['success'=>true];
             }
         }

         //pre_nursery section 
         if($request->section == "pre_nursery"){
            $scores = $request->except('student_id','section','grade');
            PreNurseryExam::upsert($scores['data'], ['id'],['value']);
            return response()->json(['success'=>true]);
         }

          $scores = collect($request->data);
          $chunk = $scores->chunk(12);

       //transforms the data collected from the exam page
       $result = $chunk->transform(function($item, $key){
            $items = $item->flatten();
           
            return [
                $items[0]=>$items[1],
                $items[2]=>$items[3],
                $items[4]=>$items[5],
                $items[6]=>$items[7],
                $items[8]=>$items[9],
                $items[10]=>$items[11],
                $items[12]=>$items[13],
                $items[14]=>$items[15],
                $items[16]=>$items[17],
                $items[18]=>$items[19],
                $items[20]=>$items[21],
                $items[22]=>$items[23]
            ];
        });
        // PrimaryExam::insert($result->toArray());
       $success= PrimaryExam::upsert(
            $result->toArray(),
            ['id'],
            ['subject','first_ca','second_ca','exam','total','remark']
        );

        if($success){
            return ['success'=>true];
        }
      }
      /**
       * Gets the page for the affective disposition
       */
      public function affectiveDisposition(Request $request){
         
        $students = Student::with('primaryAffective')->where('grade',$request->grade)->paginate(20)->withQueryString();
        //paginator increment
        $page= 0;
        if(request()->page > 1){
            $page = $students->firstItem()-1;
        }
        $grade = $request->grade;
        $selectedstudent = $request->currentStudent;
        $affective= isset($students[$selectedstudent]->primaryAffective[0])? $students[$selectedstudent]->primaryAffective[0]: [];
     
        if($request->currentStudent == 0){
            $studentid = isset($students[0]->id)? $students[0]->id : 0;
        }else{
            $studentid = $request->studentid;
        }
        $section = $request->section;
          return inertia('Students/affectivedisposition', compact('students','page','grade','selectedstudent','studentid','affective','section'));
      }
      /**
       * Saves the affective disposition
       */
      public function saveAffective(Request $request){
          //return $request->all();
          $request->validate([
            //   'alertness'=>'required',
            //   'responsibility'=>'required',
            //   'appearance'=>'required',
            //   'property'=>'required',
            //   'independently'=>'required',
            //   'work'=>'required',
            //   'honesty'=>'required',
            //   'peers'=>'required',
            //   'leadership'=>'required',
            //   'politeness'=>'required',
            //   'confidence'=>'required',
            //   'speaking'=>'required',
              'studentid'=>'required',
          ]);
          $request->merge(['term'=>'Third term','session'=>'2021/2022']);
    
          primaryAffective::updateOrCreate(['id'=>$request->id, 'studentid'=>$request->studentid, 'term'=>$request->term, 'session'=>$request->session], $request->all());
          return $request->all();
      }

      /**
       * Get the attendance page
       */
      public function getAttendance(Request $request){
          $students = Student::with('attendance')->where('grade',$request->grade)->get();
          $grade = $request->grade;
        return inertia('Students/attendance',compact('students','grade'));
      }
      /**
       * Save attendance
       */
      public function attendance(Request $request){
          $form = collect($request->all());
          $chunk = $form->chunk(7);
         
        $transformed = $chunk->transform(function($item, $key){
            $item = $item->flatten();
           return [
               $item[0] => $item[1],
               $item[2] => $item[3],
               $item[4] => $item[5],
               $item[6] => $item[7],
               $item[8] => $item[9],
               $item[10] => $item[11],
               $item[12] => $item[13],
               'session' => '2021/2022',
               'term' => 'second term'
           ];
        });

        $success= attendance::upsert(
            $transformed->toArray(),
            ['id'],
            ['no_of_times_school_opened','no_of_times_present','no_of_times_absent','no_of_times_late','no_of_times_absent_from_drills','studentid']
        );

        return $success;
      }
      /**
       * Gets physical development
       */
      public function getPhysicalDevelopment(Request $request){
          $students = Student::with('physicaldevelopment')->where('grade',$request->grade)->get();
          return inertia('Students/physicaldevelopment', compact('students'));
      }
      /**
       * Save the physical development
       */
      public function physicalDevelopment(Request $request){
        $form = collect($request->all());
        $chunk = $form->chunk(6);
        $transformed = $chunk->transform(function($item, $key){
            $item = $item->flatten();
              return [
                $item[0] => $item[1],
                $item[2] => $item[3],
                $item[4] => $item[5],
                $item[6] => $item[7],
                $item[8] => $item[9],
                $item[10] => $item[11],
                'session' => '2021/2022',
                'term'   => 'second term',
              ];
        });

        $success= physicaldevelopment::upsert(
            $transformed->toArray(),
            ['id'],
            ['initial_height','current_height','initial_weight','current_weight','studentid','session','term','studentid']
        );
        return $success;
      }

      /**
       * Student's remarks
       */
      public function getStudentsRemarks(Request $request){
        $students = Student::with(['remarks'=>function($query) use ($request) {
            $query->where('term','first term')->where('session','2022/2023');
        }])->where('grade',$request->grade)->get();
        $grade = $request->grade;
        return inertia('Students/remarks',compact('students','grade'));
      }

      /**
       * Saves student's remarks
       */
      public function saveStudentsRemarks(Request $request){
        //dd($request->all());
        remark::updateOrCreate([
            'id'=>$request->id
        ],$request->all());
        return response()->json(['success'=>true]);
      }
}
