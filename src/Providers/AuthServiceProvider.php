<?php

namespace Vng\DennisCore\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Spatie\Permission\Models\Permission;
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
use Vng\DennisCore\Models\NationalParty;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegionalParty;
use Vng\DennisCore\Models\RegistrationCode;
use Vng\DennisCore\Models\Role;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Models\Video;
use Vng\DennisCore\Policies\AddressPolicy;
use Vng\DennisCore\Policies\AgeGroupPolicy;
use Vng\DennisCore\Policies\ContactPolicy;
use Vng\DennisCore\Policies\DownloadPolicy;
use Vng\DennisCore\Policies\EmploymentTypePolicy;
use Vng\DennisCore\Policies\InstrumentPolicy;
use Vng\DennisCore\Policies\InstrumentTrackerPolicy;
use Vng\DennisCore\Policies\InstrumentTypePolicy;
use Vng\DennisCore\Policies\LinkPolicy;
use Vng\DennisCore\Policies\LocalPartyPolicy;
use Vng\DennisCore\Policies\LocationPolicy;
use Vng\DennisCore\Policies\ManagerPolicy;
use Vng\DennisCore\Policies\NationalPartyPolicy;
use Vng\DennisCore\Policies\NeighbourhoodPolicy;
use Vng\DennisCore\Policies\OrganisationPolicy;
use Vng\DennisCore\Policies\PartnershipPolicy;
use Vng\DennisCore\Policies\PermissionPolicy;
use Vng\DennisCore\Policies\ProviderPolicy;
use Vng\DennisCore\Policies\RegionalPartyPolicy;
use Vng\DennisCore\Policies\RegionPolicy;
use Vng\DennisCore\Policies\RegistrationCodePolicy;
use Vng\DennisCore\Policies\RolePolicy;
use Vng\DennisCore\Policies\SectorPolicy;
use Vng\DennisCore\Policies\TargetGroupPolicy;
use Vng\DennisCore\Policies\TargetGroupRegisterPolicy;
use Vng\DennisCore\Policies\TilePolicy;
use Vng\DennisCore\Policies\TownshipPolicy;
use Vng\DennisCore\Policies\VideoPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Address::class => AddressPolicy::class,
        AgeGroup::class => AgeGroupPolicy::class,
        Contact::class => ContactPolicy::class,
        Download::class => DownloadPolicy::class,
        EmploymentType::class => EmploymentTypePolicy::class,
        Instrument::class => InstrumentPolicy::class,
        InstrumentTracker::class => InstrumentTrackerPolicy::class,
        InstrumentType::class => InstrumentTypePolicy::class,
        Link::class => LinkPolicy::class,
        LocalParty::class => LocalPartyPolicy::class,
        Location::class => LocationPolicy::class,
        Manager::class => ManagerPolicy::class,
        NationalParty::class => NationalPartyPolicy::class,
        Neighbourhood::class => NeighbourhoodPolicy::class,
        Organisation::class => OrganisationPolicy::class,
        Partnership::class => PartnershipPolicy::class,
        Permission::class => PermissionPolicy::class,
        Provider::class => ProviderPolicy::class,
        RegionalParty::class => RegionalPartyPolicy::class,
        Region::class => RegionPolicy::class,
        RegistrationCode::class => RegistrationCodePolicy::class,
        Role::class => RolePolicy::class,
        Sector::class => SectorPolicy::class,
        TargetGroup::class => TargetGroupPolicy::class,
        TargetGroupRegister::class => TargetGroupRegisterPolicy::class,
        Tile::class => TilePolicy::class,
        Township::class => TownshipPolicy::class,
        Video::class => VideoPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
