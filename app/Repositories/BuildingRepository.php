<?php

namespace App\Repositories;

use App\Models\Building;
use Illuminate\Database\Eloquent\Collection;

class BuildingRepository extends AbstractRepository
{
    /**
     * @param string $type
     * @return Building
     */
    public function findByType(string $type): Building
    {
        return Building::where('type', $type)->first();
    }

    /**
     * @param integer $id
     * @return Collection|false
     */
    public function getForVillage(int $id)
    {
        if (!$village = $this->container->villages->find($id)) {
            return false;
        }

        return $village->buildings;
    }
}
