<?php

namespace Vng\DennisCore\Commands\Setup;

use Illuminate\Console\Command;
use Vng\DennisCore\Models\Instrument;
use Webpatser\Uuid\Uuid;

class CreateTestInstrument extends Command
{
    protected $signature = 'setup:create-test-instrument';
    protected $description = 'Create a instrument for testing purposes';

    public function handle(): int
    {
        $this->getOutput()->writeln('creating test instrument...');

        (new Instrument([
            'name' => 'Test instrument',
            'uuid' => (string) Uuid::generate(4),
            'is_active' => true,
            'short_description' => 'samenvatting',
            'description' => 'omschrijving',
        ]))
            ->saveQuietly();

        $this->getOutput()->writeln('creating test instrument finished!');
        return 0;
    }
}
