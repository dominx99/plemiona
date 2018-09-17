<?php

namespace App\Controllers;

use App\Models\Army;
use App\Models\Building;
use App\Models\Requirement;
use App\Models\User;
use requirements;

// ! remove this class before production
class PrepareDatabaseController extends Controller
{
    public function truncate()
    {
        $this->removeAllData();
    }

    public function drop()
    {
        $this->dropAllTables();
    }

    protected function removeAllData()
    {
        foreach (User::get() as $user) {

            foreach ($user->villages as $village) {
                $village->buildings()->detach();
                $village->armies()->detach();

                $village->delete();
            }

            $user->delete();
        }

        $this->removePreviousData();

        $this->auth->logout();
    }

    public function prepare()
    {
        $this->removePreviousData();

        $this->prepareBuildings();
        $this->prepareArmies();
        $this->prepareRequirements();
    }

    protected function prepareBuildings()
    {
        $buildings = $this->config->get('buildings.all_buildings');

        foreach ($buildings as $building) {
            $building = Building::create($building);

            $this->prepareCostsForBuilding($building);
        }
    }

    protected function prepareArmies()
    {
        $armies = $this->config->get('armies.all_armies');

        foreach ($armies as $army) {
            Army::create($army);
        }
    }

    protected function prepareCostsForBuilding(Building $building)
    {
        $building->costs()->delete();

        // 25 lvli budynków
        for ($i = 0; $i <= 25; $i++) {
            $costRatio = $this->config->get("buildings.{$building->type}.cost_ratio");
            $timeRatio = $this->config->get("buildings.{$building->type}.time_ratio");

            $costRatio = round($costRatio, 0);
            $timeRatio = round($timeRatio, 0);

            $building->costs()->create([
                'level' => $i,
                'value' => $i * $costRatio,
                'time'  => $i * $timeRatio,
            ]);
        }
    }

    protected function prepareRequirementsForBuilding(Building $building, int $level)
    {
        if (!$requirements = $this->config->get("requirements.buildings.{$building->type}.{$level}")) {
            return;
        }

        foreach ($requirements as $type => $reqLevel) {
            $reqBuilding = $this->buildings->FindByType($type);

            $building->requirements()->create([
                'requirementable_level' => $level,
                'building_id'           => $reqBuilding->id,
                'level'                 => $reqLevel,
            ]);
        }
    }

    protected function removePreviousData()
    {
        Requirement::truncate();
        Army::truncate();

        foreach (Building::get() as $building) {
            $building->costs()->delete();

            $building->delete();
        }
    }

    protected function prepareRequirements()
    {
        $this->prepareRequirementsForBuildings();
        $this->prepareRequirementsForArmies();
    }

    protected function prepareRequirementsForBuildings()
    {
        foreach (Building::get() as $building) {
            foreach ($building->costs as $cost) {
                $this->prepareRequirementsForBuilding($building, $cost->level);
            }
        }
    }

    protected function prepareRequirementsForArmies()
    {
        foreach (Army::get() as $army) {
            $this->prepareRequirementsForArmy($army);
        }
    }

    protected function prepareRequirementsForArmy(Army $army)
    {
        if (!$requirements = $this->config->get("requirements.armies.{$army->type}")) {
            return;
        }

        foreach ($requirements as $type => $reqLevel) {
            $reqBuilding = $this->buildings->FindByType($type);

            $army->requirements()->create([
                'building_id' => $reqBuilding->id,
                'level'       => $reqLevel,
            ]);
        }
    }

    protected function dropAllTables()
    {
        $schema = $this->db->schema();

        $schema->dropIfExists('armies');
        $schema->dropIfExists('army_village');
        $schema->dropIfExists('buildings');
        $schema->dropIfExists('building_costs');
        $schema->dropIfExists('building_village');
        $schema->dropIfExists('requirements');
        $schema->dropIfExists('timings');
        $schema->dropIfExists('users');
        $schema->dropIfExists('villages');
    }
}
