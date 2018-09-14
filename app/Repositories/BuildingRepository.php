<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Collection;

class BuildingRepository extends AbstractRepository
{
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
