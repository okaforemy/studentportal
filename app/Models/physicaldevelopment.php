<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class physicaldevelopment extends Model
{
    use HasFactory;

    /**
     * Get the Student associated with the physicaldevelopment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function Student(): HasOne
    {
        return $this->hasOne(Student::class, 'id');
    }
}
