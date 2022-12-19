<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\InstrumentTrackerValidation;
use Vng\DennisCore\Models\InstrumentTracker;

class InstrumentTrackerCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', InstrumentTracker::class);
    }

    public function rules(): array
    {
        return InstrumentTrackerValidation::make($this)->getCreationRules();
    }
}
