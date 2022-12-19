<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\DownloadValidation;
use Vng\DennisCore\Models\Download;

class DownloadCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Download::class);
    }

    public function rules(): array
    {
        return DownloadValidation::make($this)->getCreationRules();
    }
}
