<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'village_id',
        'expedition_id',
        'is_sender',
        'win',
        'title',
        'description',
        'power',
        'defense',
    ];

    public function expedition()
    {
        return $this->belongsTo(Expedition::class);
    }
}
