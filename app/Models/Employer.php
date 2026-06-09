<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $fillable = [

        'user_id',
        'company_name',
        'slug',
        'industry',
        'description',
        'address',
        'website',
        'logo',

        'phone',
        'email',
        'company_size',
        'founded_year',
        'facebook',
        'linkedin',
        'banner',

        'is_approved',
        'approved_at',
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

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}
