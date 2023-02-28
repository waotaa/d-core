<?php

namespace Vng\DennisCore\Services\ImExport;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Models\NationalParty;

class NationalPartyFromArrayService extends BaseFromArrayService
{
    public function handle(): ?Model
    {
        $data = $this->data;

        /** @var NationalParty $localParty */
        $nationalParty = NationalParty::query()->firstOrNew([
            'slug' => $data['slug'],
        ], [
            'name' => $data['name'],
        ]);
        $nationalParty->save();
        return $nationalParty;
    }
}