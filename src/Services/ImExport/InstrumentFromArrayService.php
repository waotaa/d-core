<?php

namespace Vng\DennisCore\Services\ImExport;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Enums\LocationEnum;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Models\Download;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Link;
use Vng\DennisCore\Models\Location;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegistrationCode;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Models\Video;

class InstrumentFromArrayService extends BaseFromArrayService
{
    public function handle(): ?Model
    {
        $data = $this->data;

        /** @var Instrument $instrument */
        $instrument = Instrument::query()->firstOrNew([
            'name' => $data['name'],
            'uuid' => $data['uuid'],
        ]);

        $instrument = $instrument->fill($data);

        // Organisation
        if (!is_null($data['organisation'])) {
            $organisation = OrganisationFromArrayService::create($data['organisation']);
            $instrument->organisation()->associate($organisation);
        }

        $this->associateProviderToInstrument($instrument, $data);
        $instrument->saveQuietly();

        $this->addContactsToInstrument($instrument, $data);

        $this->addDownloadsToInstrument($instrument, $data);
        $this->addLinksToInstrument($instrument, $data);
        $this->addLocationsToInstrument($instrument, $data);
        $this->addRegistrationCodesToInstrument($instrument, $data);
        $this->addVideosToInstrument($instrument, $data);

        $this->attachAgeGroupsByName($instrument, $data);
        $this->attachEmploymentTypesByName($instrument, $data);
        $this->attachSectorsByName($instrument, $data);
        $this->attachTargetGroupRegistersByName($instrument, $data);
        $this->attachTileByName($instrument, $data);
        $this->attachTargetGroupsByName($instrument, $data);
        $this->attachAvailableRegionsByName($instrument, $data);
        $this->attachAvailableTownshipsByName($instrument, $data);
        $this->attachAvailableNeighbourhoodsByName($instrument, $data);

        return $instrument;
    }

    public function associateProviderToInstrument(Instrument $instrument, $instrumentData): ?Instrument
    {
        $field = 'provider';
        if (!isset($instrumentData[$field])) {
            return null;
        }
        $providerData = $instrumentData[$field];

        $provider = ProviderFromArrayService::create($providerData);
        $instrument->provider()->associate($provider);
        return $instrument;
    }

    public function addContactsToInstrument(Instrument $instrument, $instrumentData): Instrument
    {
        if (!isset($instrumentData['contacts'])) {
            return $instrument;
        }

        // apply the organisation of the instrument to all contacts
        $instrumentData = static::addOrganisationDataToChildProperty($instrumentData, 'contacts');

        /** @var Instrument $instrument */
        $instrument = ContactFromArrayService::attachToContactableModel($instrument, $instrumentData['contacts']);
        return $instrument;
    }

    public function addDownloadsToInstrument(Instrument $instrument, $instrumentData): Instrument
    {
        $field = 'downloads';
        foreach ($instrumentData[$field] as $downloadData) {
            $this->addDownload($instrument, $downloadData);
        }
        return $instrument;
    }

    public function addDownload(Instrument $instrument, $downloadData): Download
    {
        $download = new Download($downloadData);
        $download->instrument()->associate($instrument);
        $download->saveQuietly();
        return $download;
    }

    public function addLinksToInstrument(Instrument $instrument, $instrumentData): Instrument
    {
        $field = 'links';
        foreach ($instrumentData[$field] as $linkData) {
            $this->addLink($instrument, $linkData);
        }
        return $instrument;
    }

    public function addLink(Instrument $instrument, $linkData): Link
    {
        $link = new Link($linkData);
        $link->instrument()->associate($instrument);
        $link->saveQuietly();
        return $link;
    }

    public function addLocationsToInstrument(Instrument $instrument, $instrumentData)
    {
        $field = 'locations';
        foreach ($instrumentData[$field] as $locationData) {
            $locationData['organisation'] = $instrumentData['organisation'];
            $this->addLocation($instrument, $locationData);
        }
    }

    public function addLocation(Instrument $instrument, $locationData): Location
    {
        $location = new Location();

        if ($locationData['type']['name']) {
            $locationType = new LocationEnum($locationData['type']['name']);
            $location->type = $locationType;
        }

        unset($locationData['type']);
        $location = $location->fill($locationData);

        if (isset($locationData['address'])) {
            // apply the organisation of the location (instrument) to the address
            $locationData['address']['organisation'] = $locationData['organisation'];

            $address = AddressFromArrayService::create($locationData['address']);
            $location->address()->associate($address);
        }

        $location->instrument()->associate($instrument);

        $location->saveQuietly();
        return $location;
    }

    public function addRegistrationCodesToInstrument(Instrument $instrument, $instrumentData): Instrument
    {
        $field = 'registration_codes';
        foreach ($instrumentData[$field] as $registrationCodeData) {
            $this->addRegistrationCode($instrument, $registrationCodeData);
        }
        return $instrument;
    }

    public function addRegistrationCode(Instrument $instrument, $registrationCodeData): RegistrationCode
    {
        $registrationCode = new RegistrationCode($registrationCodeData);
        $registrationCode->instrument()->associate($instrument);
        $registrationCode->saveQuietly();
        return $registrationCode;
    }

    public function addVideosToInstrument(Instrument $instrument, $instrumentData): Instrument
    {
        $field = 'videos';
        foreach ($instrumentData[$field] as $videoData) {
            $this->addVideo($instrument, $videoData);
        }
        return $instrument;
    }

    public function addVideo(Instrument $instrument, $videoData): Video
    {
        $video = new Video($videoData);
        $video->instrument()->associate($instrument);
        $video->saveQuietly();
        return $video;
    }

    public function attachAgeGroupsByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['age_groups'])) {
            return;
        }
        $ageGroupsData = collect($instrumentData['age_groups']);
        $ageGroups = AgeGroup::query()->whereIn('description', $ageGroupsData->pluck('description'));
        $instrument->ageGroups()->syncWithoutDetaching($ageGroups->pluck('id'));
    }

    public function attachEmploymentTypesByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['employment_types'])) {
            return;
        }
        $employmentsTypesData = collect($instrumentData['employment_types']);
        $employmentsTypes = EmploymentType::query()->whereIn('description', $employmentsTypesData->pluck('description'));
        $instrument->employmentTypes()->syncWithoutDetaching($employmentsTypes->pluck('id'));
    }

    public function attachSectorsByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['sectors'])) {
            return;
        }
        $sectorsData = collect($instrumentData['sectors']);
        $sectors = Sector::query()->whereIn('description', $sectorsData->pluck('description'));
        $instrument->sectors()->syncWithoutDetaching($sectors->pluck('id'));
    }

    public function attachTargetGroupRegistersByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['target_group_registers'])) {
            return;
        }
        $targetGroupRegistersData = collect($instrumentData['target_group_registers']);
        $targetGroupRegisters= TargetGroupRegister::query()->whereIn('description', $targetGroupRegistersData->pluck('description'));
        $instrument->targetGroupRegisters()->syncWithoutDetaching($targetGroupRegisters->pluck('id'));
    }

    public function attachTargetGroupsByName(Instrument $instrument, $instrumentData)
    {
        $field = 'target_groups';
        if (!isset($instrumentData[$field])) {
            return;
        }
        $targetGroupData = collect($instrumentData[$field]);

        // make sure all custom targetGroups exist
        $customTargetGroups = $targetGroupData->filter(fn ($tg) => !!$tg['custom']);
        $customTargetGroups->each(function ($targetGroupData) {
            TargetGroup::query()->firstOrCreate(
                ['description' => $targetGroupData['description']],
                ['custom' => true],
            );
        });

        $targetGroups = TargetGroup::query()->whereIn('description', $targetGroupData->pluck('description'));
        $instrument->targetGroups()->syncWithoutDetaching($targetGroups->pluck('id'));
    }

    public function attachTileByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['tiles'])) {
            return;
        }
        $tilesData = collect($instrumentData['tiles']);
        $tiles = Tile::query()->whereIn('name', $tilesData->pluck('name'));
        $instrument->tiles()->syncWithoutDetaching($tiles->pluck('id'));
    }

    public function attachAvailableRegionsByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['available_regions'])) {
            return;
        }
        $availableRegionsData = collect($instrumentData['available_regions']);
        $regions = Region::query()->whereIn('name', $availableRegionsData->pluck('name'));
        $instrument->availableRegions()->syncWithoutDetaching($regions->pluck('id'));
    }

    public function attachAvailableTownshipsByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['available_townships'])) {
            return;
        }
        $availableTownshipsData = collect($instrumentData['available_townships']);
        $townships = Township::query()->whereIn('name', $availableTownshipsData->pluck('name'));
        $instrument->availableTownships()->syncWithoutDetaching($townships->pluck('id'));
    }

    public function attachAvailableNeighbourhoodsByName(Instrument $instrument, $instrumentData)
    {
        if (!isset($instrumentData['available_neighbourhoods'])) {
            return;
        }
        $availableNeighbourhoodsData = collect($instrumentData['available_neighbourhoods']);

        // make sure all neighbourhoods exist
        $availableNeighbourhoodsData->each(function ($neigbourhoodData) {
            /** @var Neighbourhood $neigbourhood */
            $neigbourhood = Neighbourhood::query()->firstOrNew(
                ['name' => $neigbourhoodData['name']]
            );
            $neigbourhood->township()->associate($neigbourhoodData['township']['id']);
        });

        $townships = Township::query()->whereIn('name', $availableNeighbourhoodsData->pluck('name'));
        $instrument->availableTownships()->syncWithoutDetaching($townships->pluck('id'));
    }
}