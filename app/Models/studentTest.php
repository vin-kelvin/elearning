<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class studentTest extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_name',
        'question_index',
        'student_index',
      
    ];

    public function parentUser()
    {
        
        return $this->belongsTo(User::class, 'parent', 'id');
    }
}
