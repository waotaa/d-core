<?php

namespace Vng\DennisCore\Models;

use Vng\DennisCore\Events\InstrumentAttachedEvent;
use Vng\DennisCore\Events\InstrumentDetachedEvent;
use Illuminate\Database\Eloquent\Relations\Pivot;

class AvailableNeighbourhoodInstrument extends Pivot
{
    protected $table = 'available_neighbourhood_instrument';

    public $incrementing = true;

    protected $dispatchesEvents = [
        'created' => InstrumentAttachedEvent::class,
        'updated' => InstrumentAttachedEvent::class,
        'deleted' => InstrumentDetachedEvent::class,
        'restored' => InstrumentAttachedEvent::class,
        'forceDeleted' => InstrumentDetachedEvent::class,
    ];
}
