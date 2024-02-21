<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\RegionPageValidation;
use Vng\DennisCore\Models\RegionPage;

class RegionPageUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('regionPage'));
    }

    public function rules(): array
    {
        $regionPage = $this->route('regionPage');
        if (!$regionPage instanceof RegionPage) {
            throw new \Exception('Cannot derive region page from route');
        }
        return RegionPageValidation::make($this)->getUpdateRules($regionPage);
    }
}
