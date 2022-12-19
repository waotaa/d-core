<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\InstrumentTypeValidation;
use Vng\DennisCore\Models\InstrumentType;

class InstrumentTypeUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('instrumentType'));
    }

    public function rules(): array
    {
        $instrumentType = $this->route('instrumentType');
        if (!$instrumentType instanceof InstrumentType) {
            throw new \Exception('Cannot derive instrumentType from route');
        }
        return InstrumentTypeValidation::make($this)->getUpdateRules($instrumentType);
    }
}
