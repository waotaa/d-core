<?php

namespace Vng\DennisCore\Models;

use Vng\DennisCore\Events\InstrumentAttachedEvent;
use Vng\DennisCore\Events\InstrumentDetachedEvent;
use Illuminate\Database\Eloquent\Relations\Pivot;

class EmploymentTypeInstrument extends Pivot
{
    protected $table = 'employment_type_instrument';

    public $incrementing = true;

    protected $dispatchesEvents =[
        'created' => InstrumentAttachedEvent::class,
        'updated' => InstrumentAttachedEvent::class,
        'deleted' => InstrumentDetachedEvent::class,
        'restored' => InstrumentAttachedEvent::class,
        'forceDeleted' => InstrumentDetachedEvent::class,
    ];
}
