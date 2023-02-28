<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\TargetGroupCreateRequest;
use Vng\DennisCore\Http\Requests\TargetGroupUpdateRequest;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Repositories\TargetGroupRepositoryInterface;

class TargetGroupRepository extends BaseRepository implements TargetGroupRepositoryInterface
{
    public string $model = TargetGroup::class;

    public function create(TargetGroupCreateRequest $request): TargetGroup
    {
        Gate::authorize('create', TargetGroup::class);
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(TargetGroup $targetGroup, TargetGroupUpdateRequest $request): TargetGroup
    {
        Gate::authorize('update', TargetGroup::class);
        return $this->saveFromRequest($targetGroup, $request);
    }

    public function saveFromRequest(TargetGroup $targetGroup, FormRequest $request): TargetGroup
    {
        $targetGroup->fill([
            'description' => $request->input('description'),
            'custom' => $request->input('custom'),
        ]);
        $targetGroup->save();
        return $targetGroup;
    }

    public function attachInstruments(TargetGroup $targetGroup, string|array $instrumentIds): TargetGroup
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($targetGroup) {
                    Gate::authorize('attachInstrument', [$targetGroup, $instrument]);
                }
            );

        $targetGroup->instruments()->syncWithoutDetaching($instrumentIds);
        return $targetGroup;
    }

    public function detachInstruments(TargetGroup $targetGroup, string|array $instrumentIds): TargetGroup
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($targetGroup) {
                    Gate::authorize('detachInstrument', [$targetGroup, $instrument]);
                }
            );

        $targetGroup->instruments()->detach($instrumentIds);
        return $targetGroup;
    }
}
