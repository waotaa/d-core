<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\SectorCreateRequest;
use Vng\DennisCore\Http\Requests\SectorUpdateRequest;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Repositories\SectorRepositoryInterface;

class SectorRepository extends BaseRepository implements SectorRepositoryInterface
{
    public string $model = Sector::class;

    public function create(SectorCreateRequest $request): Sector
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Sector $sector, SectorUpdateRequest $request): Sector
    {
        return $this->saveFromRequest($sector, $request);
    }

    public function saveFromRequest(Sector $sector, FormRequest $request): Sector
    {
        $sector->fill([
            'description' => $request->input('description'),
        ]);
        $sector->save();
        return $sector;
    }

    public function attachInstruments(Sector $sector, array|string $instrumentIds): Sector
    {
        $sector->instruments()->syncWithoutDetaching((array) $instrumentIds);
        return $sector;
    }

    public function detachInstruments(Sector $sector, array|string $instrumentIds): Sector
    {
        $sector->instruments()->detach((array) $instrumentIds);
        return $sector;
    }
}
