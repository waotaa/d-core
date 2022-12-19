<?php

namespace Vng\DennisCore\Interfaces;

use Illuminate\Database\Eloquent\Relations\HasMany;

interface IsInstrumentWatcherInterface
{
    public function instrumentTrackers(): HasMany;
}
