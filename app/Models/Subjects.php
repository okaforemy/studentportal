<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subjects extends Model
{
    use HasFactory;

    protected $fillable = ['subject','holiday','subject_teacher','category','section'];

    /**
     * Get all of the Student for the Subjects
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function Student()
    {
        return $this->belongsToMany(Student::class,'student_subjects', 'subjects_id','student_id')->withTimestamps();
    }
}

