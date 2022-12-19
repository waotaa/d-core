<?php

namespace Vng\DennisCore\Observers;

use Vng\DennisCore\Events\ElasticResourceRemoved;
use Vng\DennisCore\Events\ElasticResourceSaved;
use Vng\DennisCore\Models\SearchableModel;

class ElasticsearchObserver
{
    public function created(SearchableModel $model): void
    {
        ElasticResourceSaved::dispatch($model);
    }

    public function updated(SearchableModel $model): void
    {
        ElasticResourceSaved::dispatch($model);
    }

    public function deleted(SearchableModel $model): void
    {
        ElasticResourceRemoved::dispatch($model);
    }

    public function restored(SearchableModel $model): void
    {
        ElasticResourceSaved::dispatch($model);
    }
}
