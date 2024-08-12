<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Support\Collection;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Repositories\RegionRepositoryInterface;

class RegionRepository extends BaseRepository implements RegionRepositoryInterface
{
    public string $model = Region::class;

    public function allWithTownships(): Collection
    {
        return $this->builder()->with('townships')->get();
    }
}
