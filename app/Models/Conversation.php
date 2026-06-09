<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = [
        'candidate_id',
        'employer_id',
        'last_message',
        'last_message_at',
    ];

    public function candidate()
    {
        return $this->belongsTo(
            Candidate::class
        );
    }

    public function employer()
    {
        return $this->belongsTo(
            Employer::class
        );
    }

    public function messages()
    {
        return $this->hasMany(
            Message::class
        );
    }

    public function lastMessage()
    {
        return $this->hasOne(Message::class)
            ->latestOfMany();
    }
}
