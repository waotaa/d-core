<?php

namespace Vng\DennisCore\Services\ImExport;

use Vng\DennisCore\Services\Instrument\InstrumentExportService;
use Vng\DennisCore\Services\Provider\ProviderExportService;

class ExportService
{
    public static function export($importMark)
    {
        ProviderExportService::export($importMark);
        InstrumentExportService::export($importMark);
    }
}