<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\EmploymentTypeValidation;
use Vng\DennisCore\Models\EmploymentType;

class EmploymentTypeCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', EmploymentType::class);
    }

    public function rules(): array
    {
        return EmploymentTypeValidation::make($this)->getCreationRules();
    }
}
