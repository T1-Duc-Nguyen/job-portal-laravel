<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [

        'employer_id',
        'title',
        'slug',
        'description',
        'requirements',
        'salary_min',
        'salary_max',
        'currency',
        'reject_reason',
        'location_id',
        'category_id',
        'job_type_id',
        'status',
        'views',
        'expired_at',

    ];

    public function employer()
    {
        return $this->belongsTo(Employer::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function jobType()
    {
        return $this->belongsTo(JobType::class);
    }

    public function skills()
    {
        return $this->belongsToMany(
            Skill::class,
            'job_skills',
            'job_id',
            'skill_id'
        );
    }
}
