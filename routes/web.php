<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\SubjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[HomeController::class, 'home']);

//Students controller
Route::get('/add-students',[StudentController::class, 'index'])->name('get-addstudents');
Route::post('/add-students',[StudentController::class, 'addStudent'])->name('addstudents');
Route::get('/recently-added-students',[StudentController::class, 'getRecentlyAddedStudent']);
Route::get('/students',[StudentController::class, 'Students'])->name('students');
Route::get('/search-students',[StudentController::class, 'searchForChildren']);
Route::get('/delete-student',[StudentController::class, 'deleteStudent']);
Route::get('/students-exam-scores',[StudentController::class, 'addStudentScores']);
Route::post('/students-exam-scores', [StudentController::class, 'saveScores']);
Route::get('/affective-disposition', [StudentController::class, 'affectiveDisposition']);
Route::post('/affective-disposition', [StudentController::class, 'saveAffective']);
Route::get('/attendance',[StudentController::class, 'getAttendance']);
Route::post('/attendance',[StudentController::class, 'attendance']);
Route::get('/physical-development', [StudentController::class, 'getPhysicalDevelopment']);
Route::post('/physical-development', [StudentController::class, 'physicalDevelopment']);
Route::get('/remarks', [StudentController::class, 'getStudentsRemarks']);
Route::post('/remarks', [StudentController::class, 'saveStudentsRemarks']);

//Parents controller
Route::get('/add-parents',[ParentsController::class, 'index']);
Route::post('/add-parents',[ParentsController::class, 'store']);
Route::get('/search-for-parent',[ParentsController::class, 'searchParent']);
Route::get('/edit-parent',[ParentsController::class,'getEditParent']);
Route::post('/edit-parent',[ParentsController::class,'editParent']);
Route::get('/add-parents-only', [ParentsController::class, 'getAddParentsOnly']);
Route::post('/add-parents-only',[ParentsController::class, 'addParentsOnly']);
Route::get('/parents',[ParentsController::class, 'Parents']);
Route::post('/assign-children',[ParentsController::class, 'assignChildrenToParents']);
Route::get('/delete-parent',[ParentsController::class, 'deleteParent']);
Route::get('/edit-parent-only',[ParentsController::class,'getEditOnlyParent']);
Route::post('/edit-parent-only',[ParentsController::class, 'editOnlyParent']);

//Classes controller
Route::get('/add-class',[ClassesController::class,'index']);
Route::post('/add-class', [ClassesController::class, 'create']);
Route::get('/classes',[ClassesController::class, 'Classes'])->name('classes');
Route::post('/save-arms',[ClassesController::class, 'saveArms']);
Route::get('/edit-class',[ClassesController::class, 'getEditClasses']);
Route::post('/edit-class',[ClassesController::class, 'editClasses']);
Route::get('/delete-class', [ClassesController::class, 'deleteClasses']);
Route::get('/get-arms', [ClassesController::class, 'getArms']);
Route::get('/class-list',[ClassesController::class, 'getStudentsClass']);

//subjects routes
Route::get('/add-subjects',[SubjectController::class, 'index'])->name('addsubjects');
Route::post('/add-subjects',[SubjectController::class, 'AddSubject']);
Route::get('/assign-subjects',[SubjectController::class, 'getAssignSubject'])->name('assignsubjects');
Route::post('/assign-subjects',[SubjectController::class, 'assignSubjects']);
Route::get('/delete-subject', [SubjectController::class, 'deleteSubject']);