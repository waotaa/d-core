<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Repositories\RegionRepositoryInterface;

class RegionRepository extends BaseRepository implements RegionRepositoryInterface
{
    public string $model = Region::class;
}
