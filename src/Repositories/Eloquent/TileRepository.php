<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\TileCreateRequest;
use Vng\DennisCore\Http\Requests\TileUpdateRequest;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Repositories\TileRepositoryInterface;

class TileRepository extends BaseRepository implements TileRepositoryInterface
{
    public string $model = Tile::class;

    public function create(TileCreateRequest $request): Tile
    {
        Gate::authorize('create', Tile::class);
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Tile $tile, TileUpdateRequest $request): Tile
    {
        Gate::authorize('update', Tile::class);
        return $this->saveFromRequest($tile, $request);
    }

    public function saveFromRequest(Tile $tile, FormRequest $request): Tile
    {
        $tile->fill([
            'name' => $request->input('name'),
            'sub_title' => $request->input('sub_title'),
            'excerpt' => $request->input('excerpt'),
            'description' => $request->input('description'),
            'list' => $request->input('list'),
            'crisis_description' => $request->input('crisis_description'),
            'crisis_services' => $request->input('crisis_services'),
            'key' => $request->input('key'),
            'position' => $request->input('position'),
        ]);
        $tile->save();
        return $tile;
    }

    public function attachInstruments(Tile $tile, string|array $instrumentIds): Tile
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($tile) {
                    Gate::authorize('attachInstrument', [$tile, $instrument]);
                }
            );

        $tile->instruments()->syncWithoutDetaching($instrumentIds);
        return $tile;
    }

    public function detachInstruments(Tile $tile, string|array $instrumentIds): Tile
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($tile) {
                    Gate::authorize('detachInstrument', [$tile, $instrument]);
                }
            );

        $tile->instruments()->detach($instrumentIds);
        return $tile;
    }
}
