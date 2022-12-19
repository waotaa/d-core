<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Enums\ContactTypeEnum;
use Vng\DennisCore\Http\Requests\InstrumentCreateRequest;
use Vng\DennisCore\Http\Requests\InstrumentUpdateRequest;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;

class InstrumentRepository extends BaseRepository implements InstrumentRepositoryInterface
{
    use OwnedEntityRepository, SoftDeletableRepository;

    protected string $model = Instrument::class;

    public function create(InstrumentCreateRequest $request): Instrument
    {
        return $this->saveFromRequest(new Instrument(), $request);
    }

    public function update(Instrument $instrument, InstrumentUpdateRequest $request): Instrument
    {
        return $this->saveFromRequest($instrument, $request);
    }

    private function saveFromRequest(Instrument $instrument, FormRequest $request): Instrument
    {
        $organisationRepository = new OrganisationRepository();
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new \Exception('invalid organisation provided');
        }

        $instrument = $instrument
            ->fill([
                'name' => $request->input('name'),
                'is_active' => $request->input('is_active'),
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

    public function attachContacts(Instrument $instrument, string|array $contactIds, ?string $type = null): Instrument
    {
        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new \Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type
        ];
        $instrument->contacts()->syncWithPivotValues((array) $contactIds, $pivotValues, false);
        return $instrument;
    }

    public function detachContacts(Instrument $instrument, string|array $contactIds): Instrument
    {
        $instrument->contacts()->detach((array) $contactIds);
        return $instrument;
    }

    public function attachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument
    {
        $instrument->ageGroups()->syncWithoutDetaching((array) $ageGroupIds);
        return $instrument;
    }

    public function detachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument
    {
        $instrument->ageGroups()->detach((array) $ageGroupIds);
        return $instrument;
    }

    public function attachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument
    {
        $instrument->employmentTypes()->syncWithoutDetaching((array) $employmentTypeIds);
        return $instrument;
    }

    public function detachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument
    {
        $instrument->employmentTypes()->detach((array) $employmentTypeIds);
        return $instrument;
    }

    public function attachSectors(Instrument $instrument, string|array $sectorIds): Instrument
    {
        $instrument->sectors()->syncWithoutDetaching((array) $sectorIds);
        return $instrument;
    }

    public function detachSectors(Instrument $instrument, string|array $sectorIds): Instrument
    {
        $instrument->sectors()->detach((array) $sectorIds);
        return $instrument;
    }

    public function attachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument
    {
        $instrument->targetGroups()->syncWithoutDetaching((array) $targetGroupIds);
        return $instrument;
    }

    public function detachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument
    {
        $instrument->targetGroups()->detach((array) $targetGroupIds);
        return $instrument;
    }

    public function attachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupRegisterIds): Instrument
    {
        $instrument->targetGroupRegisters()->syncWithoutDetaching((array) $targetGroupRegisterIds);
        return $instrument;
    }

    public function detachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupRegisterIds): Instrument
    {
        $instrument->targetGroupRegisters()->detach((array) $targetGroupRegisterIds);
        return $instrument;
    }

    public function attachTiles(Instrument $instrument, string|array $tileIds): Instrument
    {
        $instrument->tiles()->syncWithoutDetaching((array) $tileIds);
        return $instrument;
    }

    public function detachTiles(Instrument $instrument, string|array $tileIds): Instrument
    {
        $instrument->tiles()->detach((array) $tileIds);
        return $instrument;
    }

    public function attachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument
    {
        $instrument->availableRegions()->syncWithoutDetaching((array) $regionIds);
        return $instrument;
    }

    public function detachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument
    {
        $instrument->availableRegions()->detach((array) $regionIds);
        return $instrument;
    }

    public function attachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument
    {
        $instrument->availableTownships()->syncWithoutDetaching((array) $townshipIds);
        return $instrument;
    }

    public function detachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument
    {
        $instrument->availableTownships()->detach((array) $townshipIds);
        return $instrument;
    }

    public function attachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument
    {
        $instrument->availableNeighbourhoods()->syncWithoutDetaching((array) $neighbourhoodIds);
        return $instrument;
    }

    public function detachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument
    {
        $instrument->availableNeighbourhoods()->detach((array) $neighbourhoodIds);
        return $instrument;
    }
}
