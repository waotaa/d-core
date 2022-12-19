<?php

namespace Vng\DennisCore\Interfaces;

use Vng\DennisCore\Models\Instrument;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Collection;

interface IsMemberInterface
{
    public function associateables(): HasMany;

    public function getAssociations(): ?Collection;

    public function townships(): MorphToMany;
    public function regions(): MorphToMany;

    public function localParties(): MorphToMany;
    public function regionalParties(): MorphToMany;
    public function nationalParties(): MorphToMany;
    public function partnerships(): MorphToMany;


    public function hasAnyAssociation(): bool;

    public function usersShareAssociation(DennisUserInterface $user): bool;

    public function managesInstrument(Instrument $instrument): bool;

    public function getAssociationsOwnedInstruments(): ?Collection;

//    public function association(): MorphTo;
//
//    public function isAssociated(): bool;
//
//    public function getAssociationType(): ?string;
//
//    public function isMemberOfRegion(): bool;
//
//    public function isMemberOfTownship(): bool;
//
//    public function isMemberOfPartnership(): bool;

}
