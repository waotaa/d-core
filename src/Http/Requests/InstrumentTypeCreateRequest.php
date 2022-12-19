<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\InstrumentValidation;
use Vng\DennisCore\Models\InstrumentType;

class InstrumentTypeCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', InstrumentType::class);
    }

    public function rules(): array
    {
        return InstrumentValidation::make($this)->getCreationRules();
    }
}
