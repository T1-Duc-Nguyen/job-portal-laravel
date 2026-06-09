<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationLog extends Model
{
    protected $table = 'application_logs';

    public $timestamps = false;

    protected $fillable = [
        'application_id',
        'status',
        'note',
        'created_at',
    ];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
