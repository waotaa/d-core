<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\InstrumentTrackerCreateRequest;
use Vng\DennisCore\Http\Requests\InstrumentTrackerUpdateRequest;
use Vng\DennisCore\Models\InstrumentTracker;

interface InstrumentTrackerRepositoryInterface extends InstrumentOwnedEntityRepositoryInterface
{
    public function create(InstrumentTrackerCreateRequest $request): InstrumentTracker;
    public function update(InstrumentTracker $instrumentTracker, InstrumentTrackerUpdateRequest $request): InstrumentTracker;
}
