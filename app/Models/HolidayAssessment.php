<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayAssessment extends Model
{
    use HasFactory;

    protected $fillable = ['subject','score','student_id','term', 'session'];

    /**
     * Get the student that owns the HolidayAssessment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(tsudent::class, 'student_id');
    }
}
