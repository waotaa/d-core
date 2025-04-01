<?php

namespace Vng\DennisCore\Commands\Dev;

use Illuminate\Database\Eloquent\Collection;
use Vng\DennisCore\Jobs\ElasticJob;
use Illuminate\Console\Command;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Services\CSV\CsvGenerator;
use Vng\DennisCore\Services\ElasticSearch\BehaviourService;
use Vng\DennisCore\Services\ElasticSearch\ElasticsearchDocumentService;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;
use Vng\DennisCore\Services\Storage\InternalStorageService;

class GenerateReport extends Command
{
    protected $signature = 'dev:report';
    protected $description = 'Create a usage report';

    public function handle(): int
    {
        $this->getOutput()->writeln('Generating report');


        $headers = [
            'totaal in database',
            'gepubliceerd in database',
//            'compleet in database',
            'totaal in elastic',
            'gepubliceerd in elastic',
//            'compleet in elastic',
            'aantal acties totaal',
            'aantal acties laatst 30 dagen',
            'totaal professionals',
            'actieve professionals'
        ];

        $rows = [];

        $csvRow = $this->getReport();
        $rows[] = $csvRow;

        // Maak een nieuwe CSV Generator instance
        $csvGenerator = new CsvGenerator();
        $csvContent = $csvGenerator
            ->setHeaders($headers)
            ->addRows($rows)
            ->generate();

        // Toon de CSV-inhoud in de console
        $this->info("CSV Inhoud:\n");
        $this->line($csvContent);

        $filename = 'csv-rapport-' . now()->format('Y-m-d') . '.csv';
        $filePath = InternalStorageService::make()->storeFile($csvContent, $filename);

        if ($filePath) {
            $this->info('CSV stored is S3 at: ' . $filePath);
        }

        return 0;
    }

    protected function getReport()
    {
        $csvRowData = [];

        $this->info('>> Global Scope report (no environments');

        $instrumentsTotalDB = $this->getInstrumentsTotalFromDB();
        $csvRowData[] = count($instrumentsTotalDB);
        $this->line('total instruments in DB: '. count($instrumentsTotalDB));

        $instrumentsDBPublished = $this->getPublishedInstrumentsFromDB();
        $csvRowData[] = count($instrumentsDBPublished);
        $this->line('published instruments in DB: '. count($instrumentsDBPublished));

//        $instrumentsDBComplete = $this->getCompleteInstrumentsFromDB($environment);
//        $csvRowData[] = count($instrumentsDBComplete);
//        $this->line('complete instruments in DB: '. count($instrumentsDBComplete));

        $instrumentsTotalElastic = $this->getInstrumentsTotalFromDashboard();
        $csvRowData[] = count($instrumentsTotalElastic);
        $this->line('total instruments in Elastic: '. count($instrumentsTotalElastic));

        $instrumentsElasticPublished = $this->getPublishedInstrumentsFromDashboard();
        $csvRowData[] = count($instrumentsElasticPublished);
        $this->line('published instruments in Elastic: '. count($instrumentsElasticPublished));

//        $instrumentsElasticComplete = $this->getCompleteInstrumentsFromDashboard($environment);
//        $csvRowData[] = count($instrumentsElasticComplete);
//        $this->line('complete instruments in Elastic: '. count($instrumentsElasticComplete));

        // behaviour
        $behaviourService = BehaviourService::make();
        $this->line('Behaviour index: ' . $behaviourService->getGeneralIndex());
        $actionCount = $behaviourService->countGeneralInteraction();
        $csvRowData[] = $actionCount;
        $this->line('total actions ' . $actionCount);

        $actionsLast30Days = BehaviourService::make()->getBehaviourLast30Days();
        $csvRowData[] = count($actionsLast30Days);
        $this->line('actions last 30 days ' . count($actionsLast30Days));

        // professionals
        $actionsAllTime = BehaviourService::make()->getAllBehaviour();
        $actionsPerUserId = $this->getUniqueProfessionalsFromActions($actionsAllTime);
        $csvRowData[] = count($actionsPerUserId);
        $this->line('totaal professionals ' . count($actionsPerUserId));

        $actionsPerUserIdLast30Days = $this->getUniqueProfessionalsFromActions($actionsLast30Days);
        $csvRowData[] = count($actionsPerUserIdLast30Days);
        $this->line('active professionals ' . count($actionsPerUserIdLast30Days));

        return $csvRowData;
    }

    protected function getInstrumentsTotalFromDB(): Collection|array
    {
        /** @var InstrumentRepositoryInterface $instrumentRepo */
        $instrumentRepo = app(InstrumentRepositoryInterface::class);
        $query = $instrumentRepo->builder();
        return $query->get();
    }

    protected function getPublishedInstrumentsFromDB(): Collection|array
    {
        /** @var InstrumentRepositoryInterface $instrumentRepo */
        $instrumentRepo = app(InstrumentRepositoryInterface::class);
        $query = $instrumentRepo->builder();
        $query = InstrumentHelper::queryPublished($query);
        return $query->get();
    }

    protected function getCompleteInstrumentsFromDB(): Collection|array
    {
        /** @var InstrumentRepositoryInterface $instrumentRepo */
        $instrumentRepo = app(InstrumentRepositoryInterface::class);
        $query = $instrumentRepo->builder();
        $query = InstrumentHelper::queryComplete($query);
        return $query->get();
    }


    protected function getInstrumentsTotalFromDashboard(): array
    {
        $index = ElasticJob::prefixIndex('instruments');
        return ElasticsearchDocumentService::make()->scrollSearch($index);
    }

    protected function getPublishedInstrumentsFromDashboard(): array
    {
        $query = [
            'bool' => [
                'filter' => [
                    ['term' => ['publish' => true]],
                    [
                        'bool' => [
                            'should' => [
                                ['range' => ['publish_from' => ['lte' => 'now/d', 'time_zone' => 'Europe/Amsterdam']]],
                                ['bool' => ['must_not' => ['exists' => ['field' => 'publish_from']]]],
                            ],
                        ],
                    ],
                    [
                        'bool' => [
                            'should' => [
                                ['range' => ['publish_to' => ['gte' => 'now/d', 'time_zone' => 'Europe/Amsterdam']]], // Inclusief publish to dag
//                                ['range' => ['publish_to' => ['gt' => 'now/d', 'time_zone' => 'Europe/Amsterdam']]], // Exclusief publish to dag
                                ['bool' => ['must_not' => ['exists' => ['field' => 'publish_to']]]],
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $index = ElasticJob::prefixIndex('instruments');
        return ElasticsearchDocumentService::make()->scrollSearch($index, $query);
    }

    protected function getCompleteInstrumentsFromDashboard(): array
    {
        $query = [
            'bool' => [
                'filter' => [
                    ['term' => ['complete' => true]]
                ],
            ],
        ];

        $index = ElasticJob::prefixIndex('instruments');
        return ElasticsearchDocumentService::make()->scrollSearch($index, $query);
    }

    public function getUniqueProfessionalsFromActions(array $actions): array
    {
        $userIdForActions = array_map(fn ($r) => $r['_source']['anonymous_id'] ?? null, $actions);
        // Verwijder mogelijke null waarden uit de array
        $userIdForActions = array_filter($userIdForActions, fn ($id) => !is_null($id));
        return array_count_values($userIdForActions);
    }
}
