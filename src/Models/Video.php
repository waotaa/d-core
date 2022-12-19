<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vng\DennisCore\Observers\VideoObserver;

class Video extends Model
{
    protected $table = 'videos';

    protected $fillable = [
        'video_identifier',
        'provider',
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(VideoObserver::class);
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }
}
