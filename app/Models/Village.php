<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'x',
        'y',
        'gold',
        'food',
    ];

    public function buildings()
    {
        return $this->belongsToMany(Building::class)->withPivot('building_level');
    }

    /**
     * @param string $building
     * @return integer
     */
    public function getBuildingLevel(string $building): int
    {
        return $this->buildings()->where('type', $building)->first()->pivot->building_level;
    }

    /**
     * @param integer $userId
     * @return boolean
     */
    public function isOwner(int $userId): bool
    {
        return $this->user_id === $userId;
    }
}
