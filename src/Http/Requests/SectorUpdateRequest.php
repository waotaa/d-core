<?php

namespace Vng\DennisCore\Http\Requests;

use Vng\DennisCore\Http\Validation\SectorValidation;
use Vng\DennisCore\Models\Sector;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SectorUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', $this->route('sector'));
    }

    public function rules(): array
    {
        $sector = $this->route('sector');
        if (!$sector instanceof Sector) {
            throw new \Exception('Cannot derive sector from route');
        }
        return SectorValidation::make($this)->getUpdateRules($sector);
    }
}
