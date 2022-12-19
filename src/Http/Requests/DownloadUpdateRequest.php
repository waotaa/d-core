<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\DownloadValidation;
use Vng\DennisCore\Models\Download;

class DownloadUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('download'));
    }

    public function rules(): array
    {
        $download = $this->route('download');
        if (!$download instanceof Download) {
            throw new \Exception('Cannot derive download from route');
        }
        return DownloadValidation::make($this)->getUpdateRules($download);
    }
}
