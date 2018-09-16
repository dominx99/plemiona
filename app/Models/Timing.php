<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    protected $fillable = [
        'done_at',
        'type',
        'object_id',
        'time',
        'active',
        'level',
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'object_id');
    }

    /**
     * @param string $time
     * @return void
     */
    public function setActive(string $time): void
    {
        $this->update([
            'active'  => 1,
            'done_at' => $time,
        ]);
    }
}
