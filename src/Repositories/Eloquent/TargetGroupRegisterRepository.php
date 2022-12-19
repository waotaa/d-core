<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\TargetGroupRegisterCreateRequest;
use Vng\DennisCore\Http\Requests\TargetGroupRegisterUpdateRequest;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Repositories\TargetGroupRegisterRepositoryInterface;

class TargetGroupRegisterRepository extends BaseRepository implements TargetGroupRegisterRepositoryInterface
{
    public string $model = TargetGroupRegister::class;

    public function create(TargetGroupRegisterCreateRequest $request): TargetGroupRegister
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(TargetGroupRegister $targetGroupRegister, TargetGroupRegisterUpdateRequest $request): TargetGroupRegister
    {
        return $this->saveFromRequest($targetGroupRegister, $request);
    }

    public function saveFromRequest(TargetGroupRegister $targetGroupRegister, FormRequest $request): TargetGroupRegister
    {
        $targetGroupRegister->fill([
            'description' => $request->input('description'),
        ]);
        $targetGroupRegister->save();
        return $targetGroupRegister;
    }

    public function attachInstruments(TargetGroupRegister $targetGroupRegister, array|string $instrumentIds): TargetGroupRegister
    {
        $targetGroupRegister->instruments()->syncWithoutDetaching((array) $instrumentIds);
        return $targetGroupRegister;
    }

    public function detachInstruments(TargetGroupRegister $targetGroupRegister, array|string $instrumentIds): TargetGroupRegister
    {
        $targetGroupRegister->instruments()->detach((array) $instrumentIds);
        return $targetGroupRegister;
    }
}
