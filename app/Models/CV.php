<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CV extends Model
{
    public $timestamps = false;

    protected $table = 'cvs';

    protected $fillable = [

        'candidate_id',

        'file_path',
        'created_at',

    ];

    protected $casts = [

        'created_at' => 'datetime',

    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }
}
