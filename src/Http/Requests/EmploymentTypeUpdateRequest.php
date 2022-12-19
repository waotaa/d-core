<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\EmploymentTypeValidation;
use Vng\DennisCore\Models\EmploymentType;

class EmploymentTypeUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('employmentType'));
    }

    public function rules(): array
    {
        $employmentType = $this->route('employmentType');
        if (!$employmentType instanceof EmploymentType) {
            throw new \Exception('Cannot derive employmentType from route');
        }
        return EmploymentTypeValidation::make($this)->getUpdateRules($employmentType);
    }
}
