<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Army extends Model
{
    protected $fillable = [
        'name',
        'type',
        'power',
        'defense',
        'capacity',
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }
}
