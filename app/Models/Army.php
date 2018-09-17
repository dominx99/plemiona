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
        'cost',
        'time',
    ];

    public function villages()
    {
        return $this->hasMany(Village::class);
    }

    public function requirements()
    {
        return $this->morphMany(Requirement::class, 'requirementable');
    }

    /**
     * @param integer $amount
     * @return void
     */
    public function increaseAmount(int $amount): void
    {
        $this->pivot->update([
            'amount' => $this->pivot->amount + $amount,
        ]);
    }
}
