<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentWithSubject extends Model
{
    protected $table = 'student_with_subjects';

    protected $fillable = [
        'student',
        'subjects',
        'test',
        'teacher',
        'description',
        'parent'
    ];
    

    public function user()
    {
        
        return $this->belongsTo(User::class, 'student', 'id' );
        
    }

    public function teacherUser()
    {
        return $this->belongsTo(User::class, 'teacher', 'id');
        
    }

    
    public function studentUser()
    {
        return $this->hasMany(User::class,  'id');
        
    }

    public function parentUser()
    {
        
        return $this->belongsTo(User::class, 'parent', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(AddSubject::class, 'subjects', 'id');
    }
    
    

}
