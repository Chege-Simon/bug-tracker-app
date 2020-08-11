<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Project extends Model
{
    public function developers()
    {
        return $this->hasMany(Developer::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
