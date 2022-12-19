<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\LocationCreateRequest;
use Vng\DennisCore\Http\Requests\LocationUpdateRequest;
use Vng\DennisCore\Models\Location;

interface LocationRepositoryInterface extends BaseRepositoryInterface
{
    public function create(LocationCreateRequest $request): Location;
    public function update(Location $location, LocationUpdateRequest $request): Location;
}
