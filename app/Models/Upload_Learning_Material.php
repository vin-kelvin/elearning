<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload_Learning_Material extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'subject');
    }

    public function uploadedby()
    {
        return $this->belongsTo(uploadedby::class, 'uploaded_by');
    }
}
