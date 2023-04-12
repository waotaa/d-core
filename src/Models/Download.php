<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vng\DennisCore\Observers\DownloadObserver;
use Vng\DennisCore\Services\DownloadsService;

class Download extends Model
{
    protected $table = 'downloads';

    protected $fillable = [
        'label',
        'url',
        'filename'
    ];

    protected static function boot()
    {
        parent::boot();
        static::observe(DownloadObserver::class);
    }

    public function delete($deleteFile = true)
    {
        if ($deleteFile) {
            DownloadsService::deleteDownloadFile($this);
        }
        return parent::delete();
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }
}
