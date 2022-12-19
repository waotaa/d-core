<?php

namespace Vng\DennisCore\Interfaces;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vng\DennisCore\Models\Organisation;

interface OrganisationEntityInterface
{
    public function organisation(): BelongsTo;
    public function getOrganisation(): ?Organisation;
}
