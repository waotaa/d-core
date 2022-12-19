<?php

namespace Vng\DennisCore\Providers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Vng\DennisCore\Models\Address;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Download;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\InstrumentTracker;
use Vng\DennisCore\Models\InstrumentType;
use Vng\DennisCore\Models\Link;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\Location;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Mutation;
use Vng\DennisCore\Models\NationalParty;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegionalParty;
use Vng\DennisCore\Models\RegistrationCode;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Models\Video;

class MorphMapServiceProvider extends ServiceProvider
{
    const MORPH_MAP = [
        'address' => Address::class,
        'age-group' => AgeGroup::class,
        'contact' => Contact::class,
        'download' => Download::class,
        'employment-type' => EmploymentType::class,
        'instrument' => Instrument::class,
        'instrument-type' => InstrumentType::class,
        'instrument-tracker' => InstrumentTracker::class,
        'link' => Link::class,
        'local-party' => LocalParty::class,
        'location' => Location::class,
        'manager' => Manager::class,
        'mutation' => Mutation::class,
        'national-party' => NationalParty::class,
        'neighbourhood' => Neighbourhood::class,
        'organisation' => Organisation::class,
        'partnership' => Partnership::class,
        'provider' => Provider::class,
        'region' => Region::class,
        'regional-party' => RegionalParty::class,
        'registration-code' => RegistrationCode::class,
        'sector' => Sector::class,
        'target-group' => TargetGroup::class,
        'target-group-register' => TargetGroupRegister::class,
        'tile' => Tile::class,
        'township' => Township::class,
        'video' => Video::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->setMorphMap();
    }

    private function setMorphMap()
    {
        Relation::morphMap(static::MORPH_MAP);
    }
}
