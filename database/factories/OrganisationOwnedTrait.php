<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\NationalParty;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\RegionalParty;

trait OrganisationOwnedTrait
{
    public function forNationalParty(NationalParty $nationalParty = null): Factory
    {
        return $this->for($nationalParty ?? NationalParty::factory(), 'organisation');
    }

    public function forRegionalParty(RegionalParty $regionalParty = null): Factory
    {
        return $this->for($regionalParty ?? RegionalParty::factory()->create(), 'organisation');
    }

    public function forLocalParty(LocalParty $localParty = null): Factory
    {
        return $this->for($localParty ?? LocalParty::factory()->create(), 'organisation');
    }

    public function forPartnership(Partnership $partnership = null): Factory
    {
        return $this->for($partnership ?? Partnership::factory(), 'organisation');
    }
}