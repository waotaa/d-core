<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\InstrumentTrackerCreateRequest;
use Vng\DennisCore\Http\Requests\InstrumentTrackerUpdateRequest;
use Vng\DennisCore\Http\Requests\LocalPartyCreateRequest;
use Vng\DennisCore\Http\Requests\LocalPartyUpdateRequest;
use Vng\DennisCore\Models\InstrumentTracker;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Repositories\InstrumentTrackerRepositoryInterface;
use Vng\DennisCore\Repositories\LocalPartyRepositoryInterface;

class InstrumentTrackerRepository extends BaseRepository implements InstrumentTrackerRepositoryInterface
{
    protected string $model = InstrumentTracker::class;

    public function new(): InstrumentTracker
    {
        return new $this->model;
    }

    public function create(InstrumentTrackerCreateRequest $request): InstrumentTracker
    {
        return $this->saveFromRequest($this->new(), $request);
    }

    public function update(InstrumentTracker $instrumentTracker, InstrumentTrackerUpdateRequest $request): InstrumentTracker
    {
        return $this->saveFromRequest($instrumentTracker, $request);
    }

    public function saveFromRequest(InstrumentTracker $instrumentTracker, FormRequest $request): InstrumentTracker
    {
        $instrumentTracker = $instrumentTracker->fill([
            'role' => $request->input('role'),
            'notification_frequency' => $request->input('notification_frequency'),
            'on_modification' => $request->input('on_modification'),
            'on_expiration' => $request->input('on_expiration'),
        ]);
        $instrumentTracker->instrument()->associate($request->input('instrument_id'));
        $instrumentTracker->manager()->associate($request->input('manager_id'));

        $instrumentTracker->save();
        return $instrumentTracker;
    }
}
