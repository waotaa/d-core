<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\SectorCreateRequest;
use Vng\DennisCore\Http\Requests\SectorUpdateRequest;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Repositories\SectorRepositoryInterface;

class SectorRepository extends BaseRepository implements SectorRepositoryInterface
{
    public string $model = Sector::class;

    public function create(SectorCreateRequest $request): Sector
    {
        Gate::authorize('create', Sector::class);
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Sector $sector, SectorUpdateRequest $request): Sector
    {
        Gate::authorize('update', Sector::class);
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
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($sector) {
                    Gate::authorize('attachInstrument', [$sector, $instrument]);
                }
            );

        $sector->instruments()->syncWithoutDetaching($instrumentIds);
        return $sector;
    }

    public function detachInstruments(Sector $sector, array|string $instrumentIds): Sector
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($sector) {
                    Gate::authorize('detachInstrument', [$sector, $instrument]);
                }
            );

        $sector->instruments()->detach($instrumentIds);
        return $sector;
    }
}
