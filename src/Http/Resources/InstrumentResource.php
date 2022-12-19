<?php

namespace Vng\DennisCore\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Vng\DennisCore\Services\ModelHelpers\InstrumentHelper;

class InstrumentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

            'uuid' => $this->uuid,
            'name' => $this->name,
            'slug' => (string) Str::slug($this->name),
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
            'organisation' => OrganisationResource::make($this->organisation),
            'provider' => ProviderResource::make($this->provider),
            'address' => AddressResource::make($this->address),
            'contacts' => ContactResource::collection($this->contacts),

            'locations' => LocationResource::collection($this->locations),

            'registration_codes' => RegistrationCodeResource::collection($this->registrationCodes),

            'tiles' => TileResource::collection($this->tiles),
            'tiles_count' => count($this->tiles),
            'age_groups' => AgeGroupResource::collection($this->ageGroups),
            'age_groups_count' => count($this->ageGroups),
            'employment_types' => EmploymentTypeResource::collection($this->employmentTypes),
            'employment_types_count' => count($this->employmentTypes),
            'sectors' => SectorResource::collection($this->sectors),
            'sectors_count' => count($this->sectors),
            'target_groups_registers' => TargetGroupRegisterResource::collection($this->targetGroupRegisters),
            'target_groups_registers_count' => count($this->targetGroupRegisters),
            'target_groups' => TargetGroupResource::collection($this->targetGroups),
            'target_groups_count' => count($this->targetGroups),

            'links' => LinkResource::collection($this->links),
            'videos' => VideoResource::collection($this->videos),
            'downloads' => DownloadResource::collection($this->downloads),

            'available_areas' => AreaInterfaceResource::collection($this->availableAreas),
            'available_areas_all' => AreaInterfaceResource::collection($this->allAvailableAreas),

            // specified availability
            'available_areas_specified' => AreaInterfaceResource::collection($this->specifiedAvailableAreas),
            'available_regions' => RegionResource::collection($this->availableRegions),
            'available_townships' => TownshipResource::collection($this->availableTownships),
            'available_neighbourhoods' => NeighbourhoodResource::collection($this->availableNeighbourhoods),

            'mutations' => MutationResource::collection($this->mutations),
            'parent_instrument' => InstrumentResource::make($this->whenLoaded($this->parentInstrument))
        ];
    }
}
