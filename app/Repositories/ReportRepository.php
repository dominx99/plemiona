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
            'is_sender'     => true,
        ]);

        $sender->reports()->create($data);
    }

    /**
     * @param \App\Models\Expedition $expedition
     * @param array $data
     * @return void
     */
    public function createOnReceiver(Expedition $expedition, array $data): void
    {
        $receiver = $expedition->receiver;
        $result   = $data['win'] ? 'przegrała' : 'wygrała';
        $title    = "Obrona twojej {$expedition->receiver->name} {$result}";

        $data = array_merge($data, [
            'expedition_id' => $expedition->id,
            'title'         => $title,
            'is_sender'     => false,
            'win'           => !$data['win'],
        ]);

        $receiver->reports()->create($data);
    }
}
