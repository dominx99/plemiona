<?php

namespace App\Repositories;

use App\Models\Army;
use App\Models\Village;

class ArmyRepository extends AbstractRepository
{
    /**
     * @param string $type
     * @return \App\Models\Army
     */
    public function findByType(string $type): Army
    {
        return Army::where('type', $type)->first();
    }

    /**
     * @param \App\Models\Village $village
     * @param integer $armyId
     * @return \App\Models\Army
     */
    public function findByVillage(Village $village, int $armyId)
    {
        return $village->armies()->where('armies.id', $armyId)->first();
    }

    /**
     * @param \App\Models\Village $village
     * @param string $type
     * @return \App\Models\Army
     */
    public function findByVillageAndType(Village $village, string $type): Army
    {
        return $village->armies()->where('armies.type', $type)->first();
    }
}
