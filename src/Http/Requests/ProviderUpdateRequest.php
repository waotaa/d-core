<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\ProviderValidation;
use Vng\DennisCore\Models\Provider;

class ProviderUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('provider'));
    }

    public function rules(): array
    {
        $provider = $this->route('provider');
        if (!$provider instanceof Provider) {
            throw new \Exception('Cannot derive provider from route');
        }
        return ProviderValidation::make($this)->getUpdateRules($provider);
    }
}
