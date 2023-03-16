<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parents extends Model
{
    use HasFactory;

    protected $table='parents';

    protected $fillable = ['fullname', 'nationality','occupation','home_address', 'office_address','email','phone','isparent'];

    public function Students(){
        return $this->belongsToMany(Student::class,'parents_student','parents_id','student_id');
    }
}
