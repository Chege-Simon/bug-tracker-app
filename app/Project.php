<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Project extends Model
{
    protected $fillable = [
        'project_name','project_description', 'project_manager',
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
