<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Developer extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email','role','profile_pic', 'project'
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function projects()
    {
        return $this->hasMany(Project::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
