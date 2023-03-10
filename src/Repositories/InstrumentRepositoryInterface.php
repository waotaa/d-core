<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\InstrumentCreateRequest;
use Vng\DennisCore\Http\Requests\InstrumentUpdateRequest;
use Vng\DennisCore\Models\Instrument;

interface InstrumentRepositoryInterface extends OwnedEntityRepositoryInterface, SoftDeletableRepositoryInterface
{
    public function create(InstrumentCreateRequest $request): Instrument;
    public function update(Instrument $instrument, InstrumentUpdateRequest $request): Instrument;

    public function attachContacts(Instrument $provider, string|array $contactIds, ?string $type = null): Instrument;
    public function detachContacts(Instrument $provider, string|array $contactIds): Instrument;

    public function attachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument;
    public function detachAgeGroups(Instrument $instrument, string|array $ageGroupIds): Instrument;

    public function attachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument;
    public function detachEmploymentTypes(Instrument $instrument, string|array $employmentTypeIds): Instrument;

    public function attachSectors(Instrument $instrument, string|array $sectorIds): Instrument;
    public function detachSectors(Instrument $instrument, string|array $sectorIds): Instrument;

    public function attachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument;
    public function detachTargetGroups(Instrument $instrument, string|array $targetGroupIds): Instrument;

    public function attachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupIds): Instrument;
    public function detachTargetGroupRegisters(Instrument $instrument, string|array $targetGroupIds): Instrument;

    public function attachTiles(Instrument $instrument, string|array $tileIds): Instrument;
    public function detachTiles(Instrument $instrument, string|array $tileIds): Instrument;


    public function attachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument;
    public function detachAvailableRegions(Instrument $instrument, string|array $regionIds): Instrument;

    public function attachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument;
    public function detachAvailableTownships(Instrument $instrument, string|array $townshipIds): Instrument;

    public function attachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument;
    public function detachAvailableNeighbourhoods(Instrument $instrument, string|array $neighbourhoodIds): Instrument;
}
