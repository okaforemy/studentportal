<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['surname','othernames','dob','sex','student_id','grade', 'reg_progress','fullname','arm', 'class_id'];

    public function Parents(){
        return $this->belongsToMany(Parents::class,'parents_student','student_id','parents_id');
    }

    
    /**
     * Get all of the subjecs for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Subjects()
    {
        return $this->belongsToMany(Subjects::class, 'student_subjects','student_id','subjects_id')->withTimestamps();
    }

    /**
     * Get all of the primaryAffective for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function primaryAffective()
    {
        return $this->hasMany(primaryAffective::class, 'studentid', 'id');
    }

    /**
     * Get the attendance associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function attendance()
    {
        return $this->hasOne(attendance::class, 'studentid', 'id');
    }

    /**
     * Get the physicaldevelopment associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function physicaldevelopment()
    {
        return $this->hasOne(physicaldevelopment::class, 'studentid', 'id');
    }

    /**
     * Get all of the remarks for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function remarks()
    {
        return $this->hasMany(remark::class, 'student_id', 'id');
    }

    /**
     * Get the holidayAssessment associated with the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function holidayAssessment()
    {
        return $this->hasMany(HolidayAssessment::class);
    }

     /**
     * Get all of the primaryExam for the Student
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function primaryExam()
    {
        return $this->hasMany(PrimaryExam::class);
    }
}
