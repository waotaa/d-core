<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\UserValidation;
use Vng\DennisCore\Models\User;

class UserCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', User::class);
    }

    public function rules(): array
    {
        return UserValidation::make($this)->getCreationRules();
    }
}
