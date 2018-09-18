<?php

namespace App\Repositories;

use App\Models\Expedition;
use App\Models\Village;

class ExpeditionRepository extends AbstractRepository
{
    /**
     * @param \App\Models\Village $sender
     * @param \App\Models\Village $receiver
     * @param array $params
     * @return void
     */
    public function startExpedition(Village $sender, Village $receiver, array $params): void
    {
        $road = $this->container->roadCalculator->calculate($sender, $receiver);

        $sender->takeArmies($params['armies']);

        $expedition = $sender->expeditions()->create([
            'receiver_id' => $params['receiver_id'],
            'type'        => $params['type'],
            'destination' => 'forwards',
            'reach_at'    => $road['reach_at'],
        ]);

        $expedition->assignArmies($params['armies']);
    }

    /**
     * @param Expedition $expedition
     * @return void
     */
    public function delete(Expedition $expedition): void
    {
        $expedition->armies()->detach();
        $expedition->delete();
    }
}
