<?php

namespace Vng\DennisCore\Jobs;

use Elasticsearch\Client;

interface ElasticJobInterface
{
    public function getClient(): Client;
}
