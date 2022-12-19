<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticRelatedResourceChanged;
use Vng\DennisCore\Models\Video;

class VideoObserver
{
    public function created(Video $video): void
    {
        $this->syncConnectedElasticResources($video);
    }

    public function updated(Video $video): void
    {
        $this->syncConnectedElasticResources($video);
    }

    public function deleted(Video $video): void
    {
        $this->syncConnectedElasticResources($video);
    }

    public function restored(Video $video): void
    {
        $this->syncConnectedElasticResources($video);
    }

    private function syncConnectedElasticResources(Video $video): void
    {
        if (!is_null($video->instrument)) {
            ElasticRelatedResourceChanged::dispatch($video->instrument, $video);
        }
    }
}
