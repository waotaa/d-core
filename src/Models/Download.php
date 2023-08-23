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
            try {
                DownloadsService::deleteDownloadFile($this);
            } catch (\Exception $e) {
                // accept for now that deleting the file failed.
                // We still want to delete the download entity though
            }
        }
        return parent::delete();
    }

    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }
}
