<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\TargetGroupRegisterValidation;
use Vng\DennisCore\Models\TargetGroupRegister;

class TargetGroupRegisterCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', TargetGroupRegister::class);
    }

    public function rules(): array
    {
        return TargetGroupRegisterValidation::make($this)->getCreationRules();
    }
}
