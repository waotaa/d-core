<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\TileValidation;
use Vng\DennisCore\Models\Tile;

class TileCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Tile::class);
    }

    public function rules(): array
    {
        return TileValidation::make($this)->getCreationRules();
    }
}
