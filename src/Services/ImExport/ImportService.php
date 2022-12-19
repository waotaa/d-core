<?php

namespace Vng\DennisCore\Services\ImExport;

use Vng\DennisCore\Services\Instrument\InstrumentImportService;
use Vng\DennisCore\Services\Provider\ProviderImportService;

class ImportService
{
    public static function import($filenameBase)
    {
        InstrumentImportService::import($filenameBase);
        ProviderImportService::import($filenameBase);
    }
}