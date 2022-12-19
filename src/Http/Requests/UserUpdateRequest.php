<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\UserValidation;
use Vng\DennisCore\Models\User;

class UserUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('user'));
    }

    public function rules(): array
    {
        $user = $this->route('user');
        if (!$user instanceof User) {
            throw new \Exception('Cannot derive user from route');
        }
        return UserValidation::make($this)->getUpdateRules($user);
    }
}
