<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\SectorValidation;
use Vng\DennisCore\Models\Sector;

class SectorCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Sector::class);
    }

    public function rules(): array
    {
        return SectorValidation::make($this)->getCreationRules();
    }
}
