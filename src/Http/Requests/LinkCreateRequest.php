<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\LinkValidation;
use Vng\DennisCore\Models\Link;

class LinkCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Link::class);
    }

    public function rules(): array
    {
        return LinkValidation::make($this)->getCreationRules();
    }
}
