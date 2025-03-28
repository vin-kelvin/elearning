<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;
    

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by', 'teacher_id');
    }

    public function testquestions()
    {
        return $this->hasMany(testquestions::class, 'quizname');
    }

    
}
