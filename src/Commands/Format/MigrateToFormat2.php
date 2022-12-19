<?php

namespace Vng\DennisCore\Commands\Format;

use Vng\DennisCore\Enums\DurationUnitEnum;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\LocationType;
use Illuminate\Console\Command;

class MigrateToFormat2 extends Command
{
    protected $signature = 'format:migrate-2';
    protected $description = 'Migrate format 1 fields to format 2';

    public function handle(): int
    {
        $this->getOutput()->writeln('starting migrating to format 2...');

        $this->call('migrate', ['--force' => true]);
        $this->call('setup:seed-characteristics');


        $this->output->writeln('migrate instrument properties');
        $this->migrateInstrumentProperties();
        $this->output->newLine(2);

        $this->output->writeln('migrate providers');
        $this->migrateProviders();
        $this->output->newLine(2);

        $this->output->writeln('migrate addresses');
        $this->migrateInstrumentAddresses();
        $this->output->newLine(2);

        $this->output->writeln('migrate location');
        $this->migrateLocation();
        $this->output->newLine(2);

        $this->getOutput()->writeln('migrating to format 2 finished!');
        return 0;
    }

    private function migrateInstrumentProperties()
    {
        $instruments = Instrument::withTrashed()->get();

        $instruments->each(function (Instrument $instrument) {
            $short_description = $instrument->short_description ?: ' ';
            $instrument->summary = $instrument->summary ?: $short_description;
            $instrument->participation_conditions = $instrument->participation_conditions ?: $instrument->conditions;
            $instrument->additional_information = $instrument->additional_information ?: $instrument->description;
            $instrument->total_duration_value = $instrument->total_duration_value ?: (int) $instrument->duration;
            $instrument->total_duration_unit = $instrument->total_duration_unit ?: $this->getDurationUnit($instrument);
            $instrument->total_costs = $instrument->total_costs ?: $instrument->costs;
            $instrument->duration_description = $instrument->duration_description ?: $instrument->duration;
            $instrument->saveQuietly();
        });
    }

    private function getDurationUnit(Instrument $instrument)
    {
        $duration_unit = $instrument->duration_unit;
        if (!is_null($duration_unit)) {
            return $duration_unit;
        }
        switch ($instrument->getRawDurationUnitAttribute()) {
            case 'Uur':
                return DurationUnitEnum::hour();
            case 'Dag':
                return DurationUnitEnum::day();
            case 'Week':
                return DurationUnitEnum::week();
            case 'Maand':
                return DurationUnitEnum::month();
            default:
                return null;
        }
    }

    public function migrateInstrumentAddresses()
    {
        $instruments = Instrument::withTrashed()->has('address')->get();

        $instruments->each(function (Instrument $instrument) {
            $instrument->addresses()->syncWithoutDetaching($instrument->address);
        });
    }

    public function migrateLocation()
    {
        $employerInstruments = Instrument::withTrashed()
            ->where('location', 'Adres')
            ->orWhere('location', 'address')
            ->get();

        /** @var LocationType $employerLocation */
        $employerLocation = LocationType::query()->where('name', 'Adres')->firstOrFail();
        $employerLocation->instruments()->syncWithoutDetaching($employerInstruments->pluck('id'));


        $employerInstruments = Instrument::withTrashed()
            ->where('location', 'Aanbieder')
            ->orWhere('location', 'provider')
            ->get();

        /** @var LocationType $employerLocation */
        $employerLocation = LocationType::query()->where('name', 'Aanbieder')->firstOrFail();
        $employerLocation->instruments()->syncWithoutDetaching($employerInstruments->pluck('id'));


        $employerInstruments = Instrument::withTrashed()
            ->where('location', 'Werkgever')
            ->orWhere('location', 'employer')
            ->get();

        /** @var LocationType $employerLocation */
        $employerLocation = LocationType::query()->where('name', 'Werkgever')->firstOrFail();
        $employerLocation->instruments()->syncWithoutDetaching($employerInstruments->pluck('id'));


        $employerInstruments = Instrument::withTrashed()
            ->where('location', 'Gemeente')
            ->orWhere('location', 'township')
            ->get();

        /** @var LocationType $employerLocation */
        $employerLocation = LocationType::query()->where('name', 'Gemeente')->firstOrFail();
        $employerLocation->instruments()->syncWithoutDetaching($employerInstruments->pluck('id'));


        $employerInstruments = Instrument::withTrashed()
            ->where('location', 'Klant thuis')
            ->orWhere('location', 'client')
            ->get();

        /** @var LocationType $employerLocation */
        $employerLocation = LocationType::query()->where('name', 'Klant thuis')->firstOrFail();
        $employerLocation->instruments()->syncWithoutDetaching($employerInstruments->pluck('id'));
    }

    public function migrateProviders()
    {
        $instruments = Instrument::withTrashed()->get();

        $instruments->each(function(Instrument $instrument) {
            $firstProvider = $instrument->providers->first();
            if (!is_null($firstProvider)) {
                $instrument->provider()->associate($firstProvider);
                $instrument->save();
            }
        });
    }
}
