<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Developer;

use App\Project;

class Ticket extends Model
{

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
