<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\TargetGroupCreateRequest;
use Vng\DennisCore\Http\Requests\TargetGroupUpdateRequest;
use Vng\DennisCore\Models\TargetGroup;

interface TargetGroupRepositoryInterface extends BaseRepositoryInterface
{
    public function create(TargetGroupCreateRequest $request): TargetGroup;
    public function update(TargetGroup $targetGroup, TargetGroupUpdateRequest $request): TargetGroup;

    public function attachInstruments(TargetGroup $targetGroup, string|array $instrumentIds): TargetGroup;
    public function detachInstruments(TargetGroup $targetGroup, string|array $instrumentIds): TargetGroup;
}
