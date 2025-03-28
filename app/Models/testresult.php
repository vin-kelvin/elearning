<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testresult extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'question_id',
        'is_answered',
        'submitted_answer',
        'is_correct',
        'correct_answer',
        'student_id',
        'teacher_id',
    ];
    public function teacherId()
    {
        return $this->belongsTo(QuestionBank::class, 'teacher_id');

    }

    public function subject()
    {
        return $this->belongsTo(AddSubject::class);
    }
}
