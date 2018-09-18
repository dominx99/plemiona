<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    protected $fillable = [
        'village_id',
        'receiver_id',
        'type',
        'destination',
        'food',
        'gold',
        'reach_at',
    ];

    protected $dates = [
        'reach_at',
    ];

    public function sender()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Village::class, 'receiver_id');
    }

    public function armies()
    {
        return $this->belongsToMany(Army::class)->withPivot('amount');
    }

    /**
     * @return boolean
     */
    public function canBeEnded(): bool
    {
        return Carbon::now() > $this->reach_at;
    }

    public function decreaseArmy(int $defense): void
    {
        foreach ($this->armies()->orderBy('armies.defense', 'desc')->get() as $army) {
            $power = $army->power * $army->pivot->amount;
            $diff  = $power - $defense;

            if ($diff > 0) {
                $amount = $diff / $army->power;
                $army->pivot->update(['amount' => $amount]);
            } else if ($diff == 0) {
                $army->pivot->update(['amount' => 0]);
            } else {
                $defense = abs($diff);
                $army->pivot->update(['amount' => 0]);
            }
        }
    }

    public function assignArmies(array $armies)
    {
        foreach ($armies as $key => $amount) {
            if ($amount <= 0) {
                continue;
            }

            $this->armies()->attach($key, ['amount' => $amount]);
        }
    }
}
