<?php

namespace Vng\DennisCore\Services\Instrument;

use Vng\DennisCore\ElasticResources\InstrumentResource;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ImExport\AbstractEntityExportService;

class InstrumentExportService extends AbstractEntityExportService
{
    protected string $entity = 'instrument';

    public function handle(): string
    {
        $instruments = Instrument::all()
            ->map(function(Instrument $instrument) {
                $instrument->import_mark = $this->importMark;
                return InstrumentResource::make($instrument)->toArray();
            });
        return $this->createExportJson($instruments);
    }
}
