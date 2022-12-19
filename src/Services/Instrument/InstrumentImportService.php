<?php

namespace Vng\DennisCore\Services\Instrument;

use Vng\DennisCore\Services\ImExport\AbstractEntityImportService;
use Vng\DennisCore\Services\ImExport\InstrumentFromArrayService;

class InstrumentImportService extends AbstractEntityImportService
{
    protected string $entity = 'instrument';

    public function handle()
    {
        $instruments = $this->getDataFromFile();
        foreach ($instruments as $instrument) {
            InstrumentFromArrayService::create($instrument);
        }
    }
}