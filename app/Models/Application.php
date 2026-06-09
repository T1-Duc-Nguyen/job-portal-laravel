<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'applications';

    protected $fillable = [
        'job_id',
        'candidate_id',
        'cv_id',
        'status',
        'reject_reason'
    ];

    // JOB
    public function job()
    {
        return $this->belongsTo(Job::class);
    }

    // CANDIDATE
    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    // CV
    public function cv()
    {
        return $this->belongsTo(CV::class);
    }

    // LOGS
    public function logs()
    {
        return $this->hasMany(ApplicationLog::class);
    }
}
