<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\ManagerValidation;

class ManagerUpdateRequest extends FormRequest implements FormRequestInterface
{
//    public function authorize(): bool
//    {
//        return Auth::user()->can('update', $this->route('manager'));
//    }

    public function rules(): array
    {
        return ManagerValidation::make($this)->getCreationRules();
    }
}
