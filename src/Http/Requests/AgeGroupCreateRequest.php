<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\AgeGroupValidation;
use Vng\DennisCore\Models\AgeGroup;

class AgeGroupCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', AgeGroup::class);
    }

    public function rules(): array
    {
        return AgeGroupValidation::make($this)->getCreationRules();
    }
}
