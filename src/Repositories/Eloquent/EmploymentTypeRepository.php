<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\EmploymentTypeCreateRequest;
use Vng\DennisCore\Http\Requests\EmploymentTypeUpdateRequest;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Repositories\EmploymentTypeRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;

class EmploymentTypeRepository extends BaseRepository implements EmploymentTypeRepositoryInterface
{
    public string $model = EmploymentType::class;

    public function create(EmploymentTypeCreateRequest $request): EmploymentType
    {
        Gate::authorize('create', EmploymentType::class);
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(EmploymentType $employmentType, EmploymentTypeUpdateRequest $request): EmploymentType
    {
        Gate::authorize('update', EmploymentType::class);
        return $this->saveFromRequest($employmentType, $request);
    }

    public function saveFromRequest(EmploymentType $employmentType, FormRequest $request): EmploymentType
    {
        $employmentType->fill([
            'description' => $request->input('description'),
        ]);
        $employmentType->save();
        return $employmentType;
    }

    public function attachInstruments(EmploymentType $employmentType, array|string $instrumentIds): EmploymentType
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($employmentType) {
                    Gate::authorize('attachInstrument', [$employmentType, $instrument]);
                }
            );

        $employmentType->instruments()->syncWithoutDetaching($instrumentIds);
        return $employmentType;
    }

    public function detachInstruments(EmploymentType $employmentType, array|string $instrumentIds): EmploymentType
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($employmentType) {
                    Gate::authorize('detachInstrument', [$employmentType, $instrument]);
                }
            );

        $employmentType->instruments()->detach($instrumentIds);
        return $employmentType;
    }
}
