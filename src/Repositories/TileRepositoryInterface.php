<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\TileCreateRequest;
use Vng\DennisCore\Http\Requests\TileUpdateRequest;
use Vng\DennisCore\Models\Tile;

interface TileRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TileCreateRequest $request): Tile;
    public function update(Tile $tile, TileUpdateRequest $request): Tile;

    public function attachInstruments(Tile $tile, string|array $instrumentIds): Tile;
    public function detachInstruments(Tile $tile, string|array $instrumentIds): Tile;
}
