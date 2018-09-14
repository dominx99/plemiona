<?php

namespace App\Repositories;

use App\Models\Village;
use Illuminate\Database\Eloquent\Collection;

class VillageRepository extends AbstractRepository
{
    /**
     * @return integer
     */
    public function userVillagesCount(): int
    {
        return $this->container->auth->user()->villages()->count();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getForUser(): Collection
    {
        return $this->container->auth->user()->villages;
    }

    public function first()
    {
        return $this->container->auth->user()
            ->villages()
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * @param integer $x
     * @param integer $y
     * @return boolean
     */
    public function existsByCoordinates(int $x, int $y): bool
    {
        return Village::where('x', $x)->where('y', $y)->exists();
    }
}
