<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\AssociateableCreateRequest;
use Vng\DennisCore\Http\Requests\AssociateableUpdateRequest;
use Vng\DennisCore\Models\Associateable;

/**
 * Remove after fully migrated to Orchid
 * Associatables are a pivot between users and an owner (morph relation)
 * This pivot is replaced by the relation between managers and organisation
 *
 * @deprecated
 */
interface AssociateableRepositoryInterface extends BaseRepositoryInterface
{
    public function create(AssociateableCreateRequest $request): Associateable;
    public function update(Associateable $associateable, AssociateableUpdateRequest $request): Associateable;
}
