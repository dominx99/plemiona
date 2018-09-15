<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timing extends Model
{
    protected $fillable = [
        'done_at',
        'type',
        'object_id',
        'active',
    ];

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
