<?php

namespace App\Controllers;

use App\Models\Building;
use App\Models\Requirement;

// ! remove this class before production
class PrepareDatabaseController extends Controller
{
    public function prepare()
    {
        $this->removePreviousData();

        $this->prepareBuildings();
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
        foreach (Building::get() as $building) {
            $building->costs()->delete();
            Requirement::truncate();

            $building->delete();
        }
    }

    protected function prepareRequirements()
    {
        $this->prepareRequirementsForBuildings();
    }

    protected function prepareRequirementsForBuildings()
    {
        foreach (Building::get() as $building) {
            foreach ($building->costs as $cost) {
                $this->prepareRequirementsForBuilding($building, $cost->level);
            }
        }
    }
}