<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    protected $fillable = [
        'village_id',
        'destination_id',
        'type',
        'destination',
        'food',
        'gold',
    ];

    public function sender()
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    public function receiver()
    {
        return $this->belongsTo(Village::class, 'destination_id');
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
        $now     = Carbon::now();
        $reachAt = Carbon::createFromTimeString($this->reach_at);

        return $now > $reachAt;
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
}
