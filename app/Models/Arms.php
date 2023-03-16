<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arms extends Model
{
    use HasFactory;

    protected $fillable = ['arm_name','classes_id'];

    public function Classes(){
        return $this->belongsTo(Classes::class);
    }
}
