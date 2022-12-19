<?php

namespace Vng\DennisCore\ElasticResources;

use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;
use Illuminate\Support\Str;

class InstrumentResource extends ElasticResource
{
    /** @var Instrument */
    protected $resource;

    public function toArray()
    {
        return [
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
