<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\RegistrationCodeCreateRequest;
use Vng\DennisCore\Http\Requests\RegistrationCodeUpdateRequest;
use Vng\DennisCore\Models\RegistrationCode;

interface RegistrationCodeRepositoryInterface extends BaseRepositoryInterface
{
    public function create(RegistrationCodeCreateRequest $request): RegistrationCode;
    public function update(RegistrationCode $registrationCode, RegistrationCodeUpdateRequest $request): RegistrationCode;
}
