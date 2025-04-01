<?php

namespace Vng\DennisCore\Services\ElasticSearch;

use Vng\DennisCore\Services\ElasticSearch\Clients\ElasticBehaviourClientBuilder;

class BehaviourService
{
    const INDEX_GENERAL = 'general_interaction';
    const INDEX_RESULT = 'result_interaction';
    const INDEX_SEARCH = 'search_interaction';
    const INDEX_SHARE = 'share_interaction';

    public function __construct(
        private ElasticsearchDocumentService $elasticsearchDocumentService
    ){
    }

    public static function make(): self
    {
        $elasticsearchDocumentService = new ElasticsearchDocumentService();
        $elasticsearchDocumentService->setClient(ElasticBehaviourClientBuilder::make());
        return new self($elasticsearchDocumentService);
    }

    public function getAllBehaviour()
    {
        return $this->elasticsearchDocumentService->scrollSearch($this->getGeneralIndex());
    }

    public function countGeneralInteraction(): int
    {
        return $this->elasticsearchDocumentService->count($this->getGeneralIndex());
    }

    public function getBehaviourLast30Days()
    {
        $query = [
            'bool' => [
                'filter' => [
                    [
                        'range' => [
                            'timestamp' => [
//                                'gte' => 'now-1M/M', // Begin van vorige maand
//                                'lt' => 'now/M',     // Begin van deze maand

                                'gte' => 'now-30d/d', // Vanaf 30 dagen geleden, vanaf middernacht
                                'lte' => 'now/d',     // Tot vandaag, tot middernacht

                                'time_zone' => 'Europe/Amsterdam',
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $this->elasticsearchDocumentService->scrollSearch($this->getGeneralIndex(), $query);
    }

    public function getGeneralIndex(): string
    {
        return $this->getIndexPrefix() . '-' . $this::INDEX_GENERAL;
    }

    private function getIndexPrefix(): ?string
    {
//        dennis-eu-prod
        return config('elastic.instances.behaviour.prefix');
    }
}