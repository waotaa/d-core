<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\ContactValidation;
use Vng\DennisCore\Models\Contact;

class ContactCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Contact::class);
    }

    public function rules(): array
    {
        return ContactValidation::make($this)->getCreationRules();
    }
}
