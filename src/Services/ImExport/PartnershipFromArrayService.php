<?php

namespace Vng\DennisCore\Services\ImExport;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\Township;

class PartnershipFromArrayService extends BaseFromArrayService
{
    public function handle(): ?Model
    {
        $data = $this->data;

        /** @var Partnership $partnership */
        $partnership = Partnership::query()->firstOrNew([
            'slug' => $data['slug'],
        ], [
            'name' => $data['name'],
        ]);
        $partnership->save();

        $townshipSlugs = collect($data['townships'])->pluck('slug');
        $townships = Township::query()->whereIn('slug', $townshipSlugs)->get();
        $partnership->townships()->syncWithoutDetaching($townships);
        return $partnership;
    }
}