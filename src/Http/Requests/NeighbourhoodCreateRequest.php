<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\NeighbourhoodValidation;
use Vng\DennisCore\Models\Neighbourhood;

class NeighbourhoodCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Neighbourhood::class);
    }

    public function rules(): array
    {
        return NeighbourhoodValidation::make($this)->getCreationRules();
    }
}
