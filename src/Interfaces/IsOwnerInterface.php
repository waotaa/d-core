<?php

namespace Vng\DennisCore\Interfaces;

use Vng\DennisCore\Models\Instrument;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface IsOwnerInterface
{
    public function getOwnerId();
    public function getOwnerClass(): string;
    public function getOwnerType(): string;
}
