<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Enums\ContactTypeEnum;
use Vng\DennisCore\Http\Requests\InstrumentCreateRequest;
use Vng\DennisCore\Http\Requests\InstrumentUpdateRequest;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Repositories\AgeGroupRepositoryInterface;
use Vng\DennisCore\Repositories\ContactRepositoryInterface;
use Vng\DennisCore\Repositories\EmploymentTypeRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Repositories\NeighbourhoodRepositoryInterface;
use Vng\DennisCore\Repositories\RegionRepositoryInterface;
use Vng\DennisCore\Repositories\SectorRepositoryInterface;
use Vng\DennisCore\Repositories\TargetGroupRegisterRepositoryInterface;
use Vng\DennisCore\Repositories\TargetGroupRepositoryInterface;
use Vng\DennisCore\Repositories\TileRepositoryInterface;
use Vng\DennisCore\Repositories\TownshipRepositoryInterface;

class InstrumentRepository extends BaseRepository implements InstrumentRepositoryInterface
{
    use OwnedEntityRepository, SoftDeletableRepository;

    protected string $model = Instrument::class;

    public function create(InstrumentCreateRequest $request): Instrument
    {
        Gate::authorize('create', Instrument::class);
        return $this->saveFromRequest(new Instrument(), $request);
    }

    public function update(Instrument $instrument, InstrumentUpdateRequest $request): Instrument
    {
        Gate::authorize('update', Instrument::class);
        return $this->saveFromRequest($instrument, $request);
    }

    private function saveFromRequest(Instrument $instrument, FormRequest $request): Instrument
    {
        $organisationRepository = new OrganisationRepository();
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new Exception('invalid organisation provided');
        }

        $instrument = $instrument
            ->fill([
                'name' => $request->input('name'),
                'is_active' => $request->input('is_active'),
                'is_temporary' => $request->input('is_temporary'),
                'publish_from' => $request->input('publish_from'),
                'publish_to' => $request->input('publish_to'),
                'summary' => $request->input('summary'),
                'aim' => $request->input('aim'),
                'method' => $request->input('method'),
                'distinctive_approach' => $request->input('distinctive_approach'),
                'target_group_description' => $request->input('target_group_description'),
                'participation_conditions' => $request->input('participation_conditions'),
                'cooperation_partners' => $request->input('cooperation_partners'),
                'additional_information' => $request->input('additional_information'),
                'work_agreements' => $request->input('work_agreements'),
                'application_instructions' => $request->input('application_instructions'),
                'intensity_hours_per_week' => $request->input('intensity_hours_per_week'),
                'intensity_description' => $request->input('intensity_description'),
                'total_duration_value' => $request->input('total_duration_value'),
                'total_duration_unit' => $request->input('total_duration_unit'),
                'duration_description' => $request->input('duration_description'),
                'total_costs' => $request->input('total_costs'),
                'costs_description' => $request->input('costs_description'),
            ]
        );

        $instrument->organisation()->associate($organisation);

        if ($request->input('instrument_type_id')) {
            $instrument->instrumentType()->associate($request->input('instrument_type_id'));
        }

        if ($request->input('provider_id')) {
            $instrument->provider()->associate($request->input('provider_id'));
        }

        $instrument->save();

        if ($request->input('available_region_ids')) {
            $this->attachAvailableRegions($instrument, $request->input('available_region_ids'));
        }
        if ($request->input('available_township_ids')) {
            $this->attachAvailableTownships($instrument, $request->input('available_township_ids'));
        }
        if ($request->input('available_neighbourhood_ids')) {
            $this->attachAvailableNeighbourhoods($instrument, $request->input('available_neighbourhood_ids'));
        }

        return $instrument;
    }

    public function attachContacts(Instrument $instrument, string|array $contactIds, ?string $type = null, ?string $label = null): Instrument
    {
        $contactIds = (array) $contactIds;
        /** @var ContactRepositoryInterface $contactRepository */
        $contactRepository = app(ContactRepositoryInterface::class);
        $contactRepository
            ->findMany($contactIds)
            ->each(
                function (Contact $contact) use ($instrument) {
                    Gate::authorize('attachContact', [$instrument, $contact]);
                }
            );

        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type,
            'label' => $label
        ];
        $instrument->contacts()->syncWithPivotValues($contactIds, $pivotValues, false);
        return $instrument;
    }

    public function detachContacts(Instrument $instrument, string|array $contactIds): Instrument
    {
        $contactIds = (array) $contactIds;
        /** @var ContactRepositoryInterface $contactRepository */
        $contactRepository = app(ContactRepositoryInterface::class);
        $contactRepository
            ->findMany($contactIds)
            ->each(
                function (Contact $contact) use ($instrument) {
                    Gate::authorize('detachContact', [$instrument, $contact]);
                }
            );

        $instrument->contacts()->detach($contactIds);
        return $instrument;
    }

    public function attachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument
    {
        $ageGroupIds = (array) $ageGroupIds;
        /** @var AgeGroupRepositoryInterface $ageGroupRepository */
        $ageGroupRepository = app(AgeGroupRepositoryInterface::class);
        $ageGroupRepository
            ->findMany($ageGroupIds)
            ->each(
                function (AgeGroup $ageGroup) use ($instrument) {
                    Gate::authorize('attachAgeGroup', [$instrument, $ageGroup]);
                }
            );

        $instrument->ageGroups()->syncWithoutDetaching($ageGroupIds);
        return $instrument;
    }

    public function detachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument
    {
        $ageGroupIds = (array) $ageGroupIds;
        /** @var AgeGroupRepositoryInterface $ageGroupRepository */
        $ageGroupRepository = app(AgeGroupRepositoryInterface::class);
        $ageGroupRepository
            ->findMany($ageGroupIds)
            ->each(
                function (AgeGroup $ageGroup) use ($instrument) {
                    Gate::authorize('detachAgeGroup', [$instrument, $ageGroup]);
                }
            );

        $instrument->ageGroups()->detach($ageGroupIds);
        return $instrument;
    }

    public function attachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument
    {
        $employmentTypeIds = (array) $employmentTypeIds;
        /** @var EmploymentTypeRepositoryInterface $employmentTypeRepository */
        $employmentTypeRepository = app(EmploymentTypeRepositoryInterface::class);
        $employmentTypeRepository
            ->findMany($employmentTypeIds)
            ->each(
                function (EmploymentType $employmentType) use ($instrument) {
                    Gate::authorize('attachEmploymentType', [$instrument, $employmentType]);
                }
            );

        $instrument->employmentTypes()->syncWithoutDetaching($employmentTypeIds);
        return $instrument;
    }

    public function detachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument
    {
        $employmentTypeIds = (array) $employmentTypeIds;
        /** @var EmploymentTypeRepositoryInterface $employmentTypeRepository */
        $employmentTypeRepository = app(EmploymentTypeRepositoryInterface::class);
        $employmentTypeRepository
            ->findMany($employmentTypeIds)
            ->each(
                function (EmploymentType $employmentType) use ($instrument) {
                    Gate::authorize('detachEmploymentType', [$instrument, $employmentType]);
                }
            );

        $instrument->employmentTypes()->detach($employmentTypeIds);
        return $instrument;
    }

    public function attachSectors(Instrument $instrument, string|array $sectorIds): Instrument
    {
        $sectorIds = (array) $sectorIds;
        /** @var SectorRepositoryInterface $sectorRepository */
        $sectorRepository = app(SectorRepositoryInterface::class);
        $sectorRepository
            ->findMany($sectorIds)
            ->each(
                function (Sector $sector) use ($instrument) {
                    Gate::authorize('attachSector', [$instrument, $sector]);
                }
            );

        $instrument->sectors()->syncWithoutDetaching($sectorIds);
        return $instrument;
    }

    public function detachSectors(Instrument $instrument, string|array $sectorIds): Instrument
    {
        $sectorIds = (array) $sectorIds;
        /** @var SectorRepositoryInterface $sectorRepository */
        $sectorRepository = app(SectorRepositoryInterface::class);
        $sectorRepository
            ->findMany($sectorIds)
            ->each(
                function (Sector $sector) use ($instrument) {
                    Gate::authorize('detachSector', [$instrument, $sector]);
                }
            );

        $instrument->sectors()->detach($sectorIds);
        return $instrument;
    }

    public function attachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument
    {
        $targetGroupIds = (array) $targetGroupIds;
        /** @var TargetGroupRepositoryInterface $targetGroupRepository */
        $targetGroupRepository = app(TargetGroupRepositoryInterface::class);
        $targetGroupRepository
            ->findMany($targetGroupIds)
            ->each(
                function (TargetGroup $targetGroup) use ($instrument) {
                    Gate::authorize('attachTargetGroup', [$instrument, $targetGroup]);
                }
            );

        $instrument->targetGroups()->syncWithoutDetaching($targetGroupIds);
        return $instrument;
    }

    public function detachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument
    {
        $targetGroupIds = (array) $targetGroupIds;
        /** @var TargetGroupRepositoryInterface $targetGroupRepository */
        $targetGroupRepository = app(TargetGroupRepositoryInterface::class);
        $targetGroupRepository
            ->findMany($targetGroupIds)
            ->each(
                function (TargetGroup $targetGroup) use ($instrument) {
                    Gate::authorize('detachTargetGroup', [$instrument, $targetGroup]);
                }
            );

        $instrument->targetGroups()->detach($targetGroupIds);
        return $instrument;
    }

    public function attachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupRegisterIds): Instrument
    {
        $targetGroupRegisterIds = (array) $targetGroupRegisterIds;
        /** @var TargetGroupRegisterRepositoryInterface $targetGroupRegisterRepository */
        $targetGroupRegisterRepository = app(TargetGroupRegisterRepositoryInterface::class);
        $targetGroupRegisterRepository
            ->findMany($targetGroupRegisterIds)
            ->each(
                function (TargetGroupRegister $targetGroupRegister) use ($instrument) {
                    Gate::authorize('attachTargetGroupRegister', [$instrument, $targetGroupRegister]);
                }
            );

        $instrument->targetGroupRegisters()->syncWithoutDetaching($targetGroupRegisterIds);
        return $instrument;
    }

    public function detachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupRegisterIds): Instrument
    {
        $targetGroupRegisterIds = (array) $targetGroupRegisterIds;
        /** @var TargetGroupRegisterRepositoryInterface $targetGroupRegisterRepository */
        $targetGroupRegisterRepository = app(TargetGroupRegisterRepositoryInterface::class);
        $targetGroupRegisterRepository
            ->findMany($targetGroupRegisterIds)
            ->each(
                function (TargetGroupRegister $targetGroupRegister) use ($instrument) {
                    Gate::authorize('detachTargetGroupRegister', [$instrument, $targetGroupRegister]);
                }
            );

        $instrument->targetGroupRegisters()->detach($targetGroupRegisterIds);
        return $instrument;
    }

    public function attachTiles(Instrument $instrument, string|array $tileIds): Instrument
    {
        $tileIds = (array) $tileIds;
        /** @var TileRepositoryInterface $tileRepository */
        $tileRepository = app(TileRepositoryInterface::class);
        $tileRepository
            ->findMany($tileIds)
            ->each(
                function (Tile $tile) use ($instrument) {
                    Gate::authorize('attachTile', [$instrument, $tile]);
                }
            );

        $instrument->tiles()->syncWithoutDetaching($tileIds);
        return $instrument;
    }

    public function detachTiles(Instrument $instrument, string|array $tileIds): Instrument
    {
        $tileIds = (array) $tileIds;
        /** @var TileRepositoryInterface $tileRepository */
        $tileRepository = app(TileRepositoryInterface::class);
        $tileRepository
            ->findMany($tileIds)
            ->each(
                function (Tile $tile) use ($instrument) {
                    Gate::authorize('detachTile', [$instrument, $tile]);
                }
            );

        $instrument->tiles()->detach($tileIds);
        return $instrument;
    }

    public function attachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument
    {
        $regionIds = (array) $regionIds;
        /** @var RegionRepositoryInterface $regionRepository */
        $regionRepository = app(RegionRepositoryInterface::class);
        $regionRepository
            ->findMany($regionIds)
            ->each(
                function (Region $region) use ($instrument) {
                    Gate::authorize('attachAvailableRegion', [$instrument, $region]);
                }
            );

        $instrument->availableRegions()->syncWithoutDetaching($regionIds);
        return $instrument;
    }

    public function detachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument
    {
        $regionIds = (array) $regionIds;
        /** @var RegionRepositoryInterface $regionRepository */
        $regionRepository = app(RegionRepositoryInterface::class);
        $regionRepository
            ->findMany($regionIds)
            ->each(
                function (Region $region) use ($instrument) {
                    Gate::authorize('detachAvailableRegion', [$instrument, $region]);
                }
            );

        $instrument->availableRegions()->detach($regionIds);
        return $instrument;
    }

    public function syncAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument
    {
        $instrument->availableRegions()->get()->each(
            function (Region $region) use ($instrument) {
                Gate::authorize('detachAvailableRegion', [$instrument, $region]);
            }
        );

        $regionIds = (array) $regionIds;
        /** @var RegionRepositoryInterface $regionRepository */
        $regionRepository = app(RegionRepositoryInterface::class);
        $regionRepository
            ->findMany($regionIds)
            ->each(
                function (Region $region) use ($instrument) {
                    Gate::authorize('attachAvailableRegion', [$instrument, $region]);
                }
            );

        $instrument->availableRegions()->sync($regionIds);
        return $instrument;
    }

    public function attachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument
    {
        $townshipIds = (array) $townshipIds;
        /** @var TownshipRepositoryInterface $townshipRepository */
        $townshipRepository = app(TownshipRepositoryInterface::class);
        $townshipRepository
            ->findMany($townshipIds)
            ->each(
                function (Township $township) use ($instrument) {
                    Gate::authorize('attachAvailableTownship', [$instrument, $township]);
                }
            );

        $instrument->availableTownships()->syncWithoutDetaching($townshipIds);
        return $instrument;
    }

    public function detachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument
    {
        $townshipIds = (array) $townshipIds;
        /** @var TownshipRepositoryInterface $townshipRepository */
        $townshipRepository = app(TownshipRepositoryInterface::class);
        $townshipRepository
            ->findMany($townshipIds)
            ->each(
                function (Township $township) use ($instrument) {
                    Gate::authorize('detachAvailableTownship', [$instrument, $township]);
                }
            );

        $instrument->availableTownships()->detach($townshipIds);
        return $instrument;
    }

    public function syncAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument
    {
        $instrument->availableTownships()->get()->each(
            function (Township $township) use ($instrument) {
                Gate::authorize('detachAvailableTownship', [$instrument, $township]);
            }
        );

        $townshipIds = (array) $townshipIds;
        /** @var TownshipRepositoryInterface $townshipRepository */
        $townshipRepository = app(TownshipRepositoryInterface::class);
        $townshipRepository
            ->findMany($townshipIds)
            ->each(
                function (Township $township) use ($instrument) {
                    Gate::authorize('attachAvailableTownship', [$instrument, $township]);
                }
            );

        $instrument->availableTownships()->sync($townshipIds);
        return $instrument;
    }

    public function attachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument
    {
        $neighbourhoodIds = (array) $neighbourhoodIds;
        /** @var NeighbourhoodRepositoryInterface $neighbourhoodRepository */
        $neighbourhoodRepository = app(NeighbourhoodRepositoryInterface::class);
        $neighbourhoodRepository
            ->findMany($neighbourhoodIds)
            ->each(
                function (Neighbourhood $neighbourhood) use ($instrument) {
                    Gate::authorize('attachAvailableNeighbourhood', [$instrument, $neighbourhood]);
                }
            );

        $instrument->availableNeighbourhoods()->syncWithoutDetaching($neighbourhoodIds);
        return $instrument;
    }

    public function detachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument
    {
        $neighbourhoodIds = (array) $neighbourhoodIds;
        /** @var NeighbourhoodRepositoryInterface $neighbourhoodRepository */
        $neighbourhoodRepository = app(NeighbourhoodRepositoryInterface::class);
        $neighbourhoodRepository
            ->findMany($neighbourhoodIds)
            ->each(
                function (Neighbourhood $neighbourhood) use ($instrument) {
                    Gate::authorize('detachAvailableNeighbourhood', [$instrument, $neighbourhood]);
                }
            );

        $instrument->availableNeighbourhoods()->detach($neighbourhoodIds);
        return $instrument;
    }

    public function syncAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument
    {
        $instrument->availableNeighbourhoods()->get()->each(
            function (Neighbourhood $neighbourhood) use ($instrument) {
                Gate::authorize('detachAvailableNeighbourhood', [$instrument, $neighbourhood]);
            }
        );

        $neighbourhoodIds = (array) $neighbourhoodIds;
        /** @var NeighbourhoodRepositoryInterface $neighbourhoodRepository */
        $neighbourhoodRepository = app(NeighbourhoodRepositoryInterface::class);
        $neighbourhoodRepository
            ->findMany($neighbourhoodIds)
            ->each(
                function (Neighbourhood $neighbourhood) use ($instrument) {
                    Gate::authorize('attachAvailableNeighbourhood', [$instrument, $neighbourhood]);
                }
            );

        $instrument->availableNeighbourhoods()->sync($neighbourhoodIds);
        return $instrument;
    }
}
