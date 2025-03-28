<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Paper;
use App\Models\AddSubject;



class testquestions extends Model
{
    use HasFactory;

    
    public function user()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    
    public function paper()
    {
        return $this->belongsTo(Paper::class, 'quizname');
    }

    public function subject()
    {
        return $this->belongsTo(AddSubject::class, 'subject_id');

    }


    
}
