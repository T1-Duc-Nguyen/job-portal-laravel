<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    protected $table = 'candidates';

    protected $fillable = [
        'user_id',
        'full_name',
        'description',
        'avatar',
        'birthday',
        'gender',
        'desired_position',
        'level',
        'job_status',
        'phone',
        'address',
        'experience',
        'education',
        'skills',
        'status',
    ];

    public function conversations()
    {
        return $this->hasMany(
            Conversation::class
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
