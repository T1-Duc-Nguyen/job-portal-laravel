<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $casts = [

        'created_at' => 'datetime',
        'updated_at' => 'datetime',

    ];

    public function jobs()
    {
        return $this->belongsToMany(
            Job::class,
            'job_skills',
            'skill_id',
            'job_id'
        );
    }

    public function candidates()
    {
        return $this->belongsToMany(
            Candidate::class,
            'candidate_skills',
            'skill_id',
            'candidate_id'
        );
    }
}
