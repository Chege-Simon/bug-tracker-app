<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Project;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_description','project_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
