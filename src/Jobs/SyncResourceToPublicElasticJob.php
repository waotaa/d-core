<?php

namespace Vng\DennisCore\Jobs;

use Vng\DennisCore\Models\SearchableModel;
use Vng\DennisCore\Models\SyncAttempt;

class SyncResourceToPublicElasticJob extends SyncResourceToElasticJob
{
    use PublicElasticClientTrait;

    public function __construct(SearchableModel $model, string $index, string $resourceClass, SyncAttempt $attempt = null)
    {
        parent::__construct($model, $index, $resourceClass, $attempt);
    }
}
