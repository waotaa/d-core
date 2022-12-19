<?php

namespace Vng\DennisCore\Commands\ImExport;

use Illuminate\Console\Command;
use Vng\DennisCore\Services\ImExport\ImportService;

class ImportDataSet extends Command
{
    protected $signature = 'import:set {json-file-base}';

    protected $description = 'Import dataset from export json';

    public function handle(): int
    {
        ImportService::import($this->argument('json-file-base'));
        return 0;
    }
}
