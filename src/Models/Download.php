<?php

namespace Vng\DennisCore\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vng\DennisCore\Observers\DownloadObserver;
use Vng\DennisCore\Services\DownloadsService;
use Vng\DennisCore\Traits\HasOwner;

class Download extends Model
{
    use HasOwner;

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

    /**
     * @deprecated remove after migration
     */
    public function instrument(): BelongsTo
    {
        return $this->belongsTo(Instrument::class);
    }

    public function instruments(): BelongsToMany
    {
        return $this->belongsToMany(Instrument::class, 'download_instrument')
            ->withTimestamps();
    }
}
