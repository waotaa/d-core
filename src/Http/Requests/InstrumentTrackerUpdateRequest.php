<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\InstrumentTrackerValidation;
use Vng\DennisCore\Models\InstrumentTracker;

class InstrumentTrackerUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('instrumentTracker'));
    }

    public function rules(): array
    {
        $instrumentTracker = $this->route('instrumentTracker');
        if (!$instrumentTracker instanceof InstrumentTracker) {
            throw new \Exception('Cannot derive instrumentTracker from route');
        }
        return InstrumentTrackerValidation::make($this)->getUpdateRules($instrumentTracker);
    }
}
