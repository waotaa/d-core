<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\ProviderValidation;
use Vng\DennisCore\Models\Provider;

class ProviderCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Provider::class);
    }

    public function rules(): array
    {
        return ProviderValidation::make($this)->getCreationRules();
    }
}
