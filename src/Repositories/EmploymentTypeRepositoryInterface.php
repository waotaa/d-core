<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\EmploymentTypeCreateRequest;
use Vng\DennisCore\Http\Requests\EmploymentTypeUpdateRequest;
use Vng\DennisCore\Models\EmploymentType;

interface EmploymentTypeRepositoryInterface extends BaseRepositoryInterface
{
    public function create(EmploymentTypeCreateRequest $request): EmploymentType;
    public function update(EmploymentType $employmentType, EmploymentTypeUpdateRequest $request): EmploymentType;

    public function attachInstruments(EmploymentType $employmentType, string|array $instrumentIds): EmploymentType;
    public function detachInstruments(EmploymentType $employmentType, string|array $instrumentIds): EmploymentType;
}
