<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\LinkValidation;
use Vng\DennisCore\Models\Link;

class LinkUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('link'));
    }

    public function rules(): array
    {
        $link = $this->route('link');
        if (!$link instanceof Link) {
            throw new \Exception('Cannot derive link from route');
        }
        return LinkValidation::make($this)->getUpdateRules($link);
    }
}
