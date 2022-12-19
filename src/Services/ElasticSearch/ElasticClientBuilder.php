<?php

namespace Vng\DennisCore\Services\ElasticSearch;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

/**
 * Creates an elastic client for the 'main' elastic instance
 */
class ElasticClientBuilder extends ClientBuilder
{
    private static $clientInstance = null;

    private function __construct()
    {
        $this
            ->setElasticCloudId(config('elastic.instances.default.cloud_id'))
            ->setBasicAuthentication(
                config('elastic.instances.default.username'),
                config('elastic.instances.default.password')
            );
    }

    public static function make(): Client
    {
        if (is_null(self::$clientInstance)) {
            self::$clientInstance = (new self())->build();
        }
        return self::$clientInstance;
    }
}
