<?php

namespace App\Repositories;

use App\Models\Building;
use App\Models\Village;
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

    /**
     * @param \App\Models\Village $village
     * @param integer $buildingId
     * @return \App\Models\Building
     */
    public function findByVillage(Village $village, int $buildingId)
    {
        return $village->buildings()->where('buildings.id', $buildingId)->first();
    }

    /**
     * @param \App\Models\Village $village
     * @param string $type
     * @return \App\Models\Building
     */
    public function findByVillageAndType(Village $village, string $type): Building
    {
        return $village->buildings()->where('buildings.type', $type)->first();
    }
}
