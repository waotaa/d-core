<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\AgeGroupValidation;
use Vng\DennisCore\Models\AgeGroup;

class AgeGroupUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('ageGroup'));
    }

    public function rules(): array
    {
        $ageGroup = $this->route('ageGroup');
        if (!$ageGroup instanceof AgeGroup) {
            throw new \Exception('Cannot derive ageGroup from route');
        }
        return AgeGroupValidation::make($this)->getUpdateRules($ageGroup);
    }
}
