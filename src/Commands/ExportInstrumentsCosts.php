<?php

namespace Vng\DennisCore\Commands;

use Vng\DennisCore\ElasticResources\Instrument\InstrumentCostResource;
use Vng\DennisCore\Models\Instrument;
use Illuminate\Console\Command;
use Vng\DennisCore\Services\StorageService;

class ExportInstrumentsCosts extends Command
{
    protected $signature = 'dennis:export-instruments-costs {mark?}';
    protected $description = 'Create a json file with all instrument costs data.';

    public function handle(): int
    {
        $this->output->writeln('exporting instruments');

        $instruments = Instrument::all();
        $instrumentResources = collect($instruments)->map(function(Instrument $instrument) {
            return InstrumentCostResource::make($instrument)->toArray();
        });

        $instrumentsJson = json_encode($instrumentResources, JSON_PRETTY_PRINT);

        $name_prefix = date('dmy');
        $filename = $name_prefix . '-instruments-costs';
        if ($this->hasArgument('mark') && !empty($this->argument('mark'))) {
            $filename = $name_prefix . '-' . $this->argument('mark') . '-instruments-costs';
        }

        StorageService::getStorage()->put("exports/{$filename}.json", $instrumentsJson);

        $this->output->writeln('finished');
        return 0;
    }
}
