<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\RegistrationCodeCreateRequest;
use Vng\DennisCore\Http\Requests\RegistrationCodeUpdateRequest;
use Vng\DennisCore\Models\RegistrationCode;
use Vng\DennisCore\Repositories\RegistrationCodeRepositoryInterface;

class RegistrationCodeRepository extends BaseRepository implements RegistrationCodeRepositoryInterface
{
    public string $model = RegistrationCode::class;

    public function create(RegistrationCodeCreateRequest $request): RegistrationCode
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(RegistrationCode $registrationCode, RegistrationCodeUpdateRequest $request): RegistrationCode
    {
        return $this->saveFromRequest($registrationCode, $request);
    }

    public function saveFromRequest(RegistrationCode $registrationCode, FormRequest $request): RegistrationCode
    {
        $registrationCode->fill([
            'code' => $request->input('code'),
            'label' => $request->input('label'),
        ]);

        $registrationCode->instrument()->associate($request->input('instrument_id'));

        $registrationCode->save();
        return $registrationCode;
    }
}
