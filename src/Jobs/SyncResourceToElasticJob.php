<?php

namespace Vng\DennisCore\Jobs;

use Elasticsearch\Common\Exceptions\NoNodesAvailableException;
use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\ElasticResources\ElasticResource;
use Vng\DennisCore\Models\SyncAttempt;
use Elasticsearch\Client;
use Vng\DennisCore\Services\ElasticSearch\ElasticClientBuilder;

class SyncResourceToElasticJob extends ElasticJob
{
    protected string $index;
    protected Model $model;
    protected string $resourceClass;

    public function __construct(Model $model, string $index, string $resourceClass, SyncAttempt $attempt = null)
    {
        parent::__construct($attempt);
        $this->model = $model;
        $this->index = $index;
        $this->resourceClass = $resourceClass;
    }

    public function handle(): void
    {
        $this->indexDocument();
    }

    protected function indexDocument()
    {
        $elasticSearchClient = $this->getClient();
        try {
            $result = $elasticSearchClient->index([
                'index' => $this->getFullIndex(),
    //            'type' => $this->model->getSearchType(),
                'id' => $this->getId(),
                'body' => $this->getResource()->toArray(),
            ]);
            $this->updateAttemptStatusWithResult($result);
        } catch (NoNodesAvailableException $noNodesAvailableException) {
            $this->release(20);
        }
    }

    public function getClient(): Client
    {
        return ElasticClientBuilder::make();
    }

    protected function getIndex(): string
    {
        return $this->index;
    }

    protected function getFullIndex(): string
    {
        return static::prefixIndex($this->index);
    }

    protected function getId(): string
    {
        return $this->model->getKey();
    }

    protected function getResource(): ElasticResource
    {
        $resource = $this->resourceClass::make($this->model);
        if (!$resource instanceof ElasticResource) {
            throw new \Exception('Invalid resource class provided');
        }
        return $resource;
    }
}
