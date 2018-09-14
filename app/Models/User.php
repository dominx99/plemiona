<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'nick',
        'password',
        'gold',
        'food',
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
