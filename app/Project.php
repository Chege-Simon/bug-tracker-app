<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Project extends Model
{
    protected $fillable = [
        'project_name','project_description', 'project_manager','owner','created_by'
    ];
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
