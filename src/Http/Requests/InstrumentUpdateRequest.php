<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\InstrumentValidation;
use Vng\DennisCore\Models\Instrument;

class InstrumentUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('instrument'));
    }

    public function rules(): array
    {
        $instrument = $this->route('instrument');
        if (!$instrument instanceof Instrument) {
            throw new \Exception('Cannot derive instrument from route');
        }
        return InstrumentValidation::make($this)->getUpdateRules($instrument);
    }
}
