<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\EmploymentTypeCreateRequest;
use Vng\DennisCore\Http\Requests\EmploymentTypeUpdateRequest;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Repositories\EmploymentTypeRepositoryInterface;

class EmploymentTypeRepository extends BaseRepository implements EmploymentTypeRepositoryInterface
{
    public string $model = EmploymentType::class;

    public function create(EmploymentTypeCreateRequest $request): EmploymentType
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(EmploymentType $employmentType, EmploymentTypeUpdateRequest $request): EmploymentType
    {
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
        $employmentType->instruments()->syncWithoutDetaching((array) $instrumentIds);
        return $employmentType;
    }

    public function detachInstruments(EmploymentType $employmentType, array|string $instrumentIds): EmploymentType
    {
        $employmentType->instruments()->detach((array) $instrumentIds);
        return $employmentType;
    }
}
