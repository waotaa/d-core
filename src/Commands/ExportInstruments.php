<?php

namespace Vng\DennisCore\Commands;

use Illuminate\Console\Command;
use Vng\DennisCore\Services\Instrument\InstrumentExportService;

class ExportInstruments extends Command
{
    protected $signature = 'dennis:export-instruments {mark?}';
    protected $description = 'Create a json file with all instrument data. This json can also be used for an import';

    public function handle(): int
    {
        $this->output->writeln('exporting instruments');

        InstrumentExportService::export($this->argument('mark'));

        $this->output->writeln('finished');
        return 0;
    }
}
