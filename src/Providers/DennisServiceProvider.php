<?php

namespace Vng\DennisCore\Providers;

use Illuminate\Support\AggregateServiceProvider;
use Vng\DennisCore\Commands\AssignRegions;
use Vng\DennisCore\Commands\Dev\PasswordGenerationTest;
use Vng\DennisCore\Commands\Elastic\DeleteIndex;
use Vng\DennisCore\Commands\Elastic\DeletePublicIndex;
use Vng\DennisCore\Commands\Elastic\GetMapping;
use Vng\DennisCore\Commands\Elastic\SyncAll;
use Vng\DennisCore\Commands\Elastic\SyncInstruments;
use Vng\DennisCore\Commands\Elastic\SyncProviders;
use Vng\DennisCore\Commands\Elastic\SyncPublicInstruments;
use Vng\DennisCore\Commands\Elastic\SyncRegionPages;
use Vng\DennisCore\Commands\Elastic\SyncRegions;
use Vng\DennisCore\Commands\Elastic\SyncTiles;
use Vng\DennisCore\Commands\Elastic\SyncTownships;
use Vng\DennisCore\Commands\ExportInstruments;
use Vng\DennisCore\Commands\ExportInstrumentsCosts;
use Vng\DennisCore\Commands\ExtractGeoData;
use Vng\DennisCore\Commands\Format\ApplyMorphMap;
use Vng\DennisCore\Commands\Format\CleanupActionLog;
use Vng\DennisCore\Commands\Format\CleanupSyncAttempts;
use Vng\DennisCore\Commands\Format\ContactsMatchOrganisations;
use Vng\DennisCore\Commands\Format\EnsureManagers;
use Vng\DennisCore\Commands\Format\EnsureOrganisations;
use Vng\DennisCore\Commands\Format\MigrateToFormat2;
use Vng\DennisCore\Commands\Geo\GeoClearApiCaches;
use Vng\DennisCore\Commands\Geo\GeoEnsureIntegrity;
use Vng\DennisCore\Commands\Geo\GeoSourceGenerate;
use Vng\DennisCore\Commands\Geo\RegionsAssign;
use Vng\DennisCore\Commands\Geo\RegionsCheckDataFromApi;
use Vng\DennisCore\Commands\Geo\RegionsCheckDataFromSource;
use Vng\DennisCore\Commands\Geo\RegionsCheckSourceFromApi;
use Vng\DennisCore\Commands\Geo\RegionsCreateDataFromSource;
use Vng\DennisCore\Commands\Geo\RegionsCreateDataSetFromApi;
use Vng\DennisCore\Commands\Geo\RegionsUpdateDataFromSource;
use Vng\DennisCore\Commands\Geo\TownshipsCheckDataFromApi;
use Vng\DennisCore\Commands\Geo\TownshipsCheckDataFromSource;
use Vng\DennisCore\Commands\Geo\TownshipsCheckSourceFromApi;
use Vng\DennisCore\Commands\Geo\TownshipsCreateDataFromSource;
use Vng\DennisCore\Commands\Geo\TownshipsCreateDataSetFromApi;
use Vng\DennisCore\Commands\Geo\TownshipsUpdateDataFromSource;
use Vng\DennisCore\Commands\ImportInstruments;
use Vng\DennisCore\Commands\ImportOldFormatInstruments;
use Vng\DennisCore\Commands\Instruments\AssignInstrumentTypes;
use Vng\DennisCore\Commands\Instruments\InstrumentSignalingCheck;
use Vng\DennisCore\Commands\Operations\CleanContacts;
use Vng\DennisCore\Commands\Operations\SetupGeoData;
use Vng\DennisCore\Commands\Reallocation\DuplicateOwnedItems;
use Vng\DennisCore\Commands\Reallocation\MoveOwnedItems;
use Vng\DennisCore\Commands\Setup\CreateTestInstrument;
use Vng\DennisCore\Commands\Setup\Install;
use Vng\DennisCore\Commands\Setup\SeedCharacteristics;
use Vng\DennisCore\Commands\Setup\Setup;
use Vng\DennisCore\Commands\Setup\SetupAuthorizationMatrix;
use Vng\DennisCore\Commands\Setup\Update;
use Vng\DennisCore\Repositories\AddressRepositoryInterface;
use Vng\DennisCore\Repositories\AgeGroupRepositoryInterface;
use Vng\DennisCore\Repositories\AssociateableRepositoryInterface;
use Vng\DennisCore\Repositories\ContactRepositoryInterface;
use Vng\DennisCore\Repositories\DownloadRepositoryInterface;
use Vng\DennisCore\Repositories\Eloquent\AddressRepository;
use Vng\DennisCore\Repositories\Eloquent\AgeGroupRepository;
use Vng\DennisCore\Repositories\Eloquent\AssociateableRepository;
use Vng\DennisCore\Repositories\Eloquent\ContactRepository;
use Vng\DennisCore\Repositories\Eloquent\DownloadRepository;
use Vng\DennisCore\Repositories\Eloquent\EmploymentTypeRepository;
use Vng\DennisCore\Repositories\Eloquent\InstrumentRepository;
use Vng\DennisCore\Repositories\Eloquent\InstrumentTrackerRepository;
use Vng\DennisCore\Repositories\Eloquent\LinkRepository;
use Vng\DennisCore\Repositories\Eloquent\LocalPartyRepository;
use Vng\DennisCore\Repositories\Eloquent\LocationRepository;
use Vng\DennisCore\Repositories\Eloquent\ManagerRepository;
use Vng\DennisCore\Repositories\Eloquent\MutationRepository;
use Vng\DennisCore\Repositories\Eloquent\NationalPartyRepository;
use Vng\DennisCore\Repositories\Eloquent\NeighbourhoodRepository;
use Vng\DennisCore\Repositories\Eloquent\OrganisationRepository;
use Vng\DennisCore\Repositories\Eloquent\PartnershipRepository;
use Vng\DennisCore\Repositories\Eloquent\ProviderRepository;
use Vng\DennisCore\Repositories\Eloquent\RegionalPartyRepository;
use Vng\DennisCore\Repositories\Eloquent\RegionPageRepository;
use Vng\DennisCore\Repositories\Eloquent\RegionRepository;
use Vng\DennisCore\Repositories\Eloquent\RegistrationCodeRepository;
use Vng\DennisCore\Repositories\Eloquent\RoleRepository;
use Vng\DennisCore\Repositories\Eloquent\SectorRepository;
use Vng\DennisCore\Repositories\Eloquent\TargetGroupRegisterRepository;
use Vng\DennisCore\Repositories\Eloquent\TargetGroupRepository;
use Vng\DennisCore\Repositories\Eloquent\TileRepository;
use Vng\DennisCore\Repositories\Eloquent\TownshipRepository;
use Vng\DennisCore\Repositories\Eloquent\VideoRepository;
use Vng\DennisCore\Repositories\EmploymentTypeRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentTrackerRepositoryInterface;
use Vng\DennisCore\Repositories\LinkRepositoryInterface;
use Vng\DennisCore\Repositories\LocalPartyRepositoryInterface;
use Vng\DennisCore\Repositories\LocationRepositoryInterface;
use Vng\DennisCore\Repositories\ManagerRepositoryInterface;
use Vng\DennisCore\Repositories\MutationRepositoryInterface;
use Vng\DennisCore\Repositories\NationalPartyRepositoryInterface;
use Vng\DennisCore\Repositories\NeighbourhoodRepositoryInterface;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;
use Vng\DennisCore\Repositories\PartnershipRepositoryInterface;
use Vng\DennisCore\Repositories\ProviderRepositoryInterface;
use Vng\DennisCore\Repositories\RegionalPartyRepositoryInterface;
use Vng\DennisCore\Repositories\RegionPageRepositoryInterface;
use Vng\DennisCore\Repositories\RegionRepositoryInterface;
use Vng\DennisCore\Repositories\RegistrationCodeRepositoryInterface;
use Vng\DennisCore\Repositories\RoleRepositoryInterface;
use Vng\DennisCore\Repositories\SectorRepositoryInterface;
use Vng\DennisCore\Repositories\TargetGroupRegisterRepositoryInterface;
use Vng\DennisCore\Repositories\TargetGroupRepositoryInterface;
use Vng\DennisCore\Repositories\TileRepositoryInterface;
use Vng\DennisCore\Repositories\TownshipRepositoryInterface;
use Vng\DennisCore\Repositories\VideoRepositoryInterface;

class DennisServiceProvider extends AggregateServiceProvider
{
    protected $providers = [
        EventServiceProvider::class,
        AuthServiceProvider::class,
        MorphMapServiceProvider::class,
    ];

    protected $commands = [
        PasswordGenerationTest::class,

        DeleteIndex::class,
        DeletePublicIndex::class,
        GetMapping::class,
        SyncAll::class,
        SyncInstruments::class,
        SyncProviders::class,
        SyncPublicInstruments::class,
        SyncRegions::class,
        SyncRegionPages::class,
        SyncTiles::class,
        SyncTownships::class,

        ApplyMorphMap::class,
        CleanupActionLog::class,
        CleanupSyncAttempts::class,
        ContactsMatchOrganisations::class,
        EnsureManagers::class,
        EnsureOrganisations::class,
        MigrateToFormat2::class,


        GeoClearApiCaches::class,
        GeoEnsureIntegrity::class,
        GeoSourceGenerate::class,
        RegionsAssign::class,
        RegionsCheckDataFromApi::class,
        RegionsCheckDataFromSource::class,
        RegionsCheckSourceFromApi::class,
        RegionsCreateDataFromSource::class,
        RegionsCreateDataSetFromApi::class,
        RegionsUpdateDataFromSource::class,
        TownshipsCheckDataFromApi::class,
        TownshipsCheckDataFromSource::class,
        TownshipsCheckSourceFromApi::class,
        TownshipsCreateDataFromSource::class,
        TownshipsCreateDataSetFromApi::class,
        TownshipsUpdateDataFromSource::class,

        CleanContacts::class,
        SetupGeoData::class,

        AssignInstrumentTypes::class,
        InstrumentSignalingCheck::class,

        DuplicateOwnedItems::class,
        MoveOwnedItems::class,

        CreateTestInstrument::class,
        Install::class,
        SeedCharacteristics::class,
        Setup::class,
        SetupAuthorizationMatrix::class,
        Update::class,

        AssignRegions::class,
        ExportInstruments::class,
        ExportInstrumentsCosts::class,
        ExtractGeoData::class,
        ImportInstruments::class,
        ImportOldFormatInstruments::class,
    ];

    public function register()
    {
        parent::register();
        $this->bindRepositoryInterfaces();

        $this->mergeConfigFrom(__DIR__.'/../../config/authorization.php', 'authorization');
        $this->mergeConfigFrom(__DIR__.'/../../config/dennis-core.php', 'dennis-core');
        $this->mergeConfigFrom(__DIR__.'/../../config/elastic.php', 'elastic');
        $this->mergeConfigFrom(__DIR__.'/../../config/filesystems.php', 'filesystems');
        $this->mergeConfigFrom(__DIR__.'/../../config/permission.php', 'permission');
    }

    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->publishConfig();
        $this->publishTranslations();
        $this->publishGeoResources();
        $this->publishApiSpecs();
        $this->registerCommands();
    }

    private function publishConfig()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../../config/authorization.php' => config_path('authorization.php'),
                __DIR__.'/../../config/dennis-core.php' => config_path('dennis-core.php'),
                __DIR__ . '/../../config/elastic.php' => config_path('elastic.php'),
                __DIR__ . '/../../config/filesystems.php' => config_path('filesystems.php'),
                __DIR__ . '/../../config/permission.php' => config_path('permission.php'),
            ], 'dennis-config');
        }
    }

    private function publishTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'dennis');

        $this->publishes([
            __DIR__.'/../../resources/lang' => lang_path('vendor/dennis'),
        ], 'dennis-lang');
    }

    private function publishGeoResources()
    {
        $this->publishes([
            __DIR__.'/../../resources/geo' => storage_path('app/fixed/geo'),
        ], 'dennis-geo');
    }

    private function publishApiSpecs()
    {
        $this->publishes([
            __DIR__.'/../../resources/openapi' => resource_path('openapi'),
        ], 'dennis-api');
    }

    private function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }
    }

    private function bindRepositoryInterfaces()
    {
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(AgeGroupRepositoryInterface::class, AgeGroupRepository::class);
        $this->app->bind(AssociateableRepositoryInterface::class, AssociateableRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(DownloadRepositoryInterface::class, DownloadRepository::class);
        $this->app->bind(EmploymentTypeRepositoryInterface::class, EmploymentTypeRepository::class);
        $this->app->bind(InstrumentRepositoryInterface::class, InstrumentRepository::class);
        $this->app->bind(InstrumentTrackerRepositoryInterface::class, InstrumentTrackerRepository::class);
        $this->app->bind(LinkRepositoryInterface::class, LinkRepository::class);
        $this->app->bind(LocalPartyRepositoryInterface::class, LocalPartyRepository::class);
        $this->app->bind(LocationRepositoryInterface::class, LocationRepository::class);
        $this->app->bind(ManagerRepositoryInterface::class, ManagerRepository::class);
        $this->app->bind(MutationRepositoryInterface::class, MutationRepository::class);
        $this->app->bind(NationalPartyRepositoryInterface::class, NationalPartyRepository::class);
        $this->app->bind(NeighbourhoodRepositoryInterface::class, NeighbourhoodRepository::class);
        $this->app->bind(OrganisationRepositoryInterface::class, OrganisationRepository::class);
        $this->app->bind(PartnershipRepositoryInterface::class, PartnershipRepository::class);
        $this->app->bind(ProviderRepositoryInterface::class, ProviderRepository::class);
        $this->app->bind(RegionalPartyRepositoryInterface::class, RegionalPartyRepository::class);
        $this->app->bind(RegionRepositoryInterface::class, RegionRepository::class);
        $this->app->bind(RegionPageRepositoryInterface::class, RegionPageRepository::class);
        $this->app->bind(RegistrationCodeRepositoryInterface::class, RegistrationCodeRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(SectorRepositoryInterface::class, SectorRepository::class);
        $this->app->bind(TargetGroupRepositoryInterface::class, TargetGroupRepository::class);
        $this->app->bind(TargetGroupRegisterRepositoryInterface::class, TargetGroupRegisterRepository::class);
        $this->app->bind(TileRepositoryInterface::class, TileRepository::class);
        $this->app->bind(TownshipRepositoryInterface::class, TownshipRepository::class);
        $this->app->bind(VideoRepositoryInterface::class, VideoRepository::class);
    }
}
