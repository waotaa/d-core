<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Helpers\Codelijsten;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;
use Illuminate\Support\Str;

class InstrumentWerkgeversdienstverleningResource extends ElasticResource
{
    /** @var Instrument */
    protected $resource;

    public function toArray()
    {
        $targetGroupRegister = null;
        if ($this->targetGroupRegisters->count() !== 0) {
            $targetGroupRegister = $this->targetGroupRegisters->filter(fn ($tgr) => $tgr->description === 'Ja')->count() === 1;
        }

        return [
            // >> SGR
            // Instrument
            'IndDoelgroepsRegister' => Codelijsten::getJaNeeNvtIndicatieCode($targetGroupRegister),  // StdIndNvt
            'IndLeerwerktraject' => Codelijsten::getJaNeeIndicatieCode($this->is_leerwerktraject),  // StdIndJN
            'IndTijdelijk' => Codelijsten::getJaNeeIndicatieCode($this->is_temporary),              // StdIndJN
            'OmsAanvraag' => $this->applications,               // AN..320 - 2785
            'OmsInstrument' => $this->description,              // AN..320 - 11757
            'OmsKortInstrument' => $this->short_description,    // AN..320 - 1751
            'OmsVoorwaarden' => $this->conditions,              // AN..320 - 5177

            'Instrument' => InstrumentResource::one($this->resource),

            'Aanbieder' => ProviderResource::one($this->provider),
            'Contactpersoon' => ContactResource::many($this->contacts),
            'Dienstverband' => EmploymentTypeResource::many($this->employmentTypes),
            'Doelgroep' => TargetGroupResource::many($this->targetGroups),
            'Download' => DownloadResource::many($this->downloads),
            'Leeftijdsgroep' => AgeGroupResource::many($this->ageGroups),
            'Link' => LinkResource::many($this->links),
            'Registratiecode' => RegistrationCodeResource::many($this->registrationCodes),
            'Sector' => SectorResource::many($this->sectors),
            'Uitvoeringslocatie' => LocationResource::many($this->locations),
            'Video' => VideoResource::many($this->videos),
            'WerklandschapTegel' => TileResource::many($this->tiles),

            // todo: beschikbaarheid?

            // >> Current
            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => (string) Str::slug($this->name),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'publish' => $this->is_active,
            'publish_from' => $this->publish_from,
            'publish_to' => $this->publish_to,

            'published' => InstrumentHelper::create($this->resource)->isPublished(),
            'complete' => InstrumentHelper::create($this->resource)->isComplete(),

            'is_leerwerktraject' => $this->is_leerwerktraject,
            'is_temporary' => $this->is_temporary,

            // descriptions
            'short_description' => $this->short_description,
            'description' => $this->description,
            'applications' => $this->applications,
            'conditions' => $this->conditions,

            // auxilary
            'import_mark' => $this->import_mark,

            // computed
            'is_national' => $this->resource->isNational(),
            'is_regional' => $this->resource->isRegional(),
            'is_local' => $this->resource->isLocal(),
            'reach' => $this->resource->getReach(),

            // relations
//            'owner' => OwnerResource::one($this->owner), // depricated
            'organisation' => OrganisationResource::one($this->organisation),
            'locations' => LocationResource::many($this->locations),

            'tiles' => TileResource::many($this->tiles),
            'tiles_count' => count($this->tiles),
            'age_groups' => AgeGroupResource::many($this->ageGroups),
            'age_groups_count' => count($this->ageGroups),
            'employment_types' => EmploymentTypeResource::many($this->employmentTypes),
            'employment_types_count' => count($this->employmentTypes),
            'sectors' => SectorResource::many($this->sectors),
            'sectors_count' => count($this->sectors),
            'target_group_registers' => TargetGroupRegisterResource::many($this->targetGroupRegisters),
            'target_group_registers_count' => count($this->targetGroupRegisters),
            'target_groups' => TargetGroupResource::many($this->targetGroups),
            'target_groups_count' => count($this->targetGroups),

            'links' => LinkResource::many($this->links),
            'videos' => VideoResource::many($this->videos),
            'downloads' => DownloadResource::many($this->downloads),

            'provider' => ProviderResource::one($this->provider),
            'contacts' => ContactResource::many($this->contacts),

            'available_areas' => AreaInterfaceResource::many($this->availableAreas),
            'available_areas_all' => AreaInterfaceResource::many($this->allAvailableAreas),

            // specified availability
            'available_areas_specified' => AreaInterfaceResource::many($this->specifiedAvailableAreas),
            'available_regions' => RegionResource::many($this->availableRegions),
            'available_townships' => TownshipResource::many($this->availableTownships),
            'available_neighbourhoods' => NeighbourhoodResource::many($this->availableNeighbourhoods),
        ];
    }
}
