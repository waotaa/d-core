<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Vng\DennisCore\Observers\InstrumentProviderObserver;

class InstrumentProvider extends Pivot
{
    protected $table = 'instrument_provider';
    public $incrementing = true;

    protected static function boot()
    {
        parent::boot();
        static::observe(InstrumentProviderObserver::class);
    }
}
