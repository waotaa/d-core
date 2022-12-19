<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\NeighbourhoodValidation;
use Vng\DennisCore\Models\Neighbourhood;

class NeighbourhoodUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('neighbourhood'));
    }

    public function rules(): array
    {
        $neighbourhood = $this->route('neighbourhood');
        if (!$neighbourhood instanceof Neighbourhood) {
            throw new \Exception('Cannot derive neighbourhood from route');
        }
        return NeighbourhoodValidation::make($this)->getUpdateRules($neighbourhood);
    }
}
