<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class attendance extends Model
{
    use HasFactory;

    protected $fillable = ['no_of_times_school_opened','no_of_times_present','no_of_times_absent','no_of_times_late','no_of_times_absent_from_drills','studentid','term','session'];

    /**
     * Get the student associated with the attendance
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function student(): HasOne
    {
        return $this->hasOne(student::class, 'id');
    }
}
