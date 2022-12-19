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
class AssociateableCreateRequest extends FormRequest implements FormRequestInterface
{
    public function authorize(): bool
    {
        return Auth::user()->can('create', Associateable::class);
    }

    public function rules(): array
    {
        return AssociateableValidation::make($this)->getCreationRules();
    }
}
