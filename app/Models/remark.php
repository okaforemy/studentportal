<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class remark extends Model
{
    use HasFactory;

    protected $fillable = ['HT_remarks', 'CT_remarks','student_id','session','term'];

    /**
     * Get the student that owns the remark
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
