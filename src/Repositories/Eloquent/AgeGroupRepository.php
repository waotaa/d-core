<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\AgeGroupCreateRequest;
use Vng\DennisCore\Http\Requests\AgeGroupUpdateRequest;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Repositories\AgeGroupRepositoryInterface;

class AgeGroupRepository extends BaseRepository implements AgeGroupRepositoryInterface
{
    public string $model = AgeGroup::class;

    public function create(AgeGroupCreateRequest $request): AgeGroup
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(AgeGroup $ageGroup, AgeGroupUpdateRequest $request): AgeGroup
    {
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
        $ageGroup->instruments()->syncWithoutDetaching((array) $instrumentIds);
        return $ageGroup;
    }

    public function detachInstruments(AgeGroup $ageGroup, array|string $instrumentIds): AgeGroup
    {
        $ageGroup->instruments()->detach((array) $instrumentIds);
        return $ageGroup;
    }
}
