<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classes extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['class_name', 'teacher_incharge','capacity', 'section'];

    public function Arms(){
        return $this->hasMany(Arms::class, 'classes_id','id');
    }
}
