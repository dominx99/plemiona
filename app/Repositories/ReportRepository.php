<?php

namespace App\Repositories;

use App\Models\Expedition;

class ReportRepository extends AbstractRepository
{
    /**
     * @param Expedition $expedition
     * @param boolean $win
     * @return void
     */
    public function createOnSender(Expedition $expedition, array $data): void
    {
        $sender = $expedition->sender;
        $result = $data['win'] ? 'powiódł się' : 'nie powiódł się';
        $title  = "Atak na wioskę {$expedition->receiver->name} {$result}";

        $data = array_merge($data, [
            'expedition_id' => $expedition->id,
            'title'         => $title,
        ]);

        $sender->reports()->create($data);
    }
}
