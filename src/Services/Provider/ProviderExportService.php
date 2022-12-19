<?php

namespace Vng\DennisCore\Services\Provider;

use Vng\DennisCore\ElasticResources\ProviderResource;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Services\ImExport\AbstractEntityExportService;

class ProviderExportService extends AbstractEntityExportService
{
    protected string $entity = 'provider';

    public function handle(): string
    {
        $providers = Provider::all()
            ->map(function(Provider $provider) {
                $provider->import_mark = $this->importMark;
                return ProviderResource::make($provider)->toArray();
            });
        return $this->createExportJson($providers);
    }
}
