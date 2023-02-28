<?php

namespace Vng\DennisCore\Services\Instrument;

use Illuminate\Support\Collection;
use Vng\DennisCore\ElasticResources\InstrumentResource;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ImExport\AbstractEntityExportService;

class InstrumentExportService extends AbstractEntityExportService
{
    protected string $entity = 'instrument';

    protected ?Collection $items = null;

    public function handle(): string
    {
        if (is_null($this->items)) {
            $this->setItems(Instrument::all());
        }

        $instruments = $this->items->map(function(Instrument $instrument) {
            $instrument->import_mark = $this->importMark;
            return InstrumentResource::make($instrument)->toArray();
        });
        return $this->createExportJson($instruments);
    }

    /**
     * @param Collection|null $items
     * @return InstrumentExportService
     */
    public function setItems($items)
    {
        $this->items = $items;
        return $this;
    }

}
