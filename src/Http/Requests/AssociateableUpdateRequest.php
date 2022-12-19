<?php

namespace Vng\DennisCore\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Vng\DennisCore\Http\Validation\AssociateableValidation;
use Vng\DennisCore\Models\Associateable;

/**
 * Remove after fully migrated to Orchid
 * Associatables are a pivot between users and an owner (morph relation)
 * This pivot is replaced by the relation between managers and organisation
 *
 * @deprecated
 */
class AssociateableUpdateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('update', 'associateable');
    }

    public function rules(): array
    {
        $associateable = $this->route('associateable');
        if (!$associateable instanceof Associateable) {
            throw new \Exception('Cannot derive associateable from route');
        }
        return AssociateableValidation::make($this)->getUpdateRules($associateable);
    }
}
