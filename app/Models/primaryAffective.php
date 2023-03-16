<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class primaryAffective extends Model
{
    use HasFactory;

    protected $fillable=[
        'alertness',
        'responsibility',
        'appearance',
        'property',
        'independently',
        'work',
        'honesty',
        'peers',
        'leadership',
        'politeness',
        'confidence',
        'speaking',
        'studentid',
        'term',
        'session',
    ];

    /**
     * Get the student that owns the primaryAffective
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo(Student::class, 'studentid');
    }
}
