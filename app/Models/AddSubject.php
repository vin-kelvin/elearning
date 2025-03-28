<?php

namespace App\Models;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddSubject extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'added_by');
    }

    public function subject()
    {
        return $this->hasMany(StudentWithSubject::class, 'subjects');
    }
    
    public function students()
    {
        return $this->belongsToMany(StudentWithSubject::class, 'student_with_subjects', 'subjects', 'student');
    }

    public function testResults()
    {
        return $this->hasMany(testresult::class);
    }


}

