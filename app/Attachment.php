<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'posted_for','file','file_type','file_size'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
