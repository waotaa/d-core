<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\RegionPageValidation;
use Vng\DennisCore\Models\RegionPage;

class RegionPageCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', RegionPage::class);
    }

    public function rules(): array
    {
        return RegionPageValidation::make($this)->getCreationRules();
    }
}
