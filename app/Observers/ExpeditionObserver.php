<?php

namespace App\Observers;

use App\Models\Expedition;
use App\Services\ArmyExpeditor;

class ExpeditionObserver
{
    /**
     * @var \App\Services\ArmyExpeditor
     */
    protected $armyExpeditor;

    /**
     * @param \App\Services\ArmyExpeditor $armyExpeditor
     */
    public function __construct(ArmyExpeditor $armyExpeditor)
    {
        $this->armyExpeditor = $armyExpeditor;
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @return void
     */
    public function retrieved(Expedition $expedition): void
    {
        if ($expedition->deleted_at) {
            return;
        }

        $this->armyExpeditor->endExpedition($expedition);
    }
}
