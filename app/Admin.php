<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{

    protected $guarded = ['email'];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function getAuthPassword()
    {
        return $this->password;
    }
}
