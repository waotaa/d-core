<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\ManagerValidation;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Manager;

class ManagerUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        $manager = $this->route('manager');

        if (!$manager) {
            /** @var IsManagerInterface $user */
            $user = $this->route('user');
            $manager = $user->getManager();
        }
        return Auth::user()->can('update', $manager);
    }

    public function rules(): array
    {
        return ManagerValidation::make($this)->getCreationRules();
    }
}
