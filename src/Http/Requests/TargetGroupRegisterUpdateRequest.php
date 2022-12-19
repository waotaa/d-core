<?php

namespace Vng\DennisCore\Http\Requests;

use Vng\DennisCore\Http\Validation\TargetGroupRegisterValidation;
use Vng\DennisCore\Models\TargetGroupRegister;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class TargetGroupRegisterUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('targetGroupRegister'));
    }

    public function rules(): array
    {
        $targetGroupRegister = $this->route('targetGroupRegister');
        if (!$targetGroupRegister instanceof TargetGroupRegister) {
            throw new \Exception('Cannot derive targetGroupRegister from route');
        }
        return TargetGroupRegisterValidation::make($this)->getUpdateRules($targetGroupRegister);
    }
}
