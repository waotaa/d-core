<?php

namespace Vng\DennisCore\Services\ImExport;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\Township;

class LocalPartyFromArrayService extends BaseFromArrayService
{
    public function handle(): Model
    {
        $data = $this->data;

        /** @var LocalParty $localParty */
        $localParty = LocalParty::query()->firstOrNew([
            'slug' => $data['slug'],
        ], [
            'name' => $data['name'],
        ]);
        $township = Township::query()->where('slug', $data['township']['slug'])->firstOrFail();
        $localParty->township()->associate($township);
        $localParty->save();

        return $localParty;
    }
}