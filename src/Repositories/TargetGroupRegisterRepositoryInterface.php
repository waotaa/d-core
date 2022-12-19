<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\TargetGroupRegisterCreateRequest;
use Vng\DennisCore\Http\Requests\TargetGroupRegisterUpdateRequest;
use Vng\DennisCore\Models\TargetGroupRegister;

interface TargetGroupRegisterRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TargetGroupRegisterCreateRequest $request): TargetGroupRegister;
    public function update(TargetGroupRegister $targetGroupRegister, TargetGroupRegisterUpdateRequest $request): TargetGroupRegister;

    public function attachInstruments(TargetGroupRegister $targetGroupRegister, string|array $instrumentIds): TargetGroupRegister;
    public function detachInstruments(TargetGroupRegister $targetGroupRegister, string|array $instrumentIds): TargetGroupRegister;
}
