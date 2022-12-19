<?php

namespace Vng\DennisCore\Services\Provider;

use Vng\DennisCore\Services\ImExport\AbstractEntityImportService;
use Vng\DennisCore\Services\ImExport\ProviderFromArrayService;

class ProviderImportService extends AbstractEntityImportService
{
    protected string $entity = 'provider';

    public function handle()
    {
        $providers = $this->getDataFromFile();
        foreach ($providers as $provider) {
            ProviderFromArrayService::create($provider);
        }
    }
}