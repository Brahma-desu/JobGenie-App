<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobDescription extends Model
{
    // Allow mass assignment on these fields
    protected $fillable = [
        'user_id',
        'job_title',
        'skills',
        'industry',
        'experience',
        'description'
    ];

    // Optional: define relationship to User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
