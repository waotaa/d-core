<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\AgeGroupCreateRequest;
use Vng\DennisCore\Http\Requests\AgeGroupUpdateRequest;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Repositories\AgeGroupRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;

class AgeGroupRepository extends BaseRepository implements AgeGroupRepositoryInterface
{
    public string $model = AgeGroup::class;

    public function create(AgeGroupCreateRequest $request): AgeGroup
    {
        Gate::authorize('create', AgeGroup::class);
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(AgeGroup $ageGroup, AgeGroupUpdateRequest $request): AgeGroup
    {
        Gate::authorize('update', AgeGroup::class);
        return $this->saveFromRequest($ageGroup, $request);
    }

    public function saveFromRequest(AgeGroup $ageGroup, FormRequest $request): AgeGroup
    {
        $ageGroup->fill([
            'description' => $request->input('description'),
        ]);
        $ageGroup->save();
        return $ageGroup;
    }

    public function attachInstruments(AgeGroup $ageGroup, array|string $instrumentIds): AgeGroup
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($ageGroup) {
                    Gate::authorize('attachInstrument', [$ageGroup, $instrument]);
                }
            );

        $ageGroup->instruments()->syncWithoutDetaching($instrumentIds);
        return $ageGroup;
    }

    public function detachInstruments(AgeGroup $ageGroup, array|string $instrumentIds): AgeGroup
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($ageGroup) {
                    Gate::authorize('detachInstrument', [$ageGroup, $instrument]);
                }
            );

        $ageGroup->instruments()->detach($instrumentIds);
        return $ageGroup;
    }
}
