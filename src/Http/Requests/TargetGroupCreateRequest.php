<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\TargetGroupValidation;
use Vng\DennisCore\Models\TargetGroup;

class TargetGroupCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', TargetGroup::class);
    }

    public function rules(): array
    {
        return TargetGroupValidation::make($this)->getCreationRules();
    }
}
