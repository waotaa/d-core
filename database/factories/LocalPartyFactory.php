<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\Township;

class LocalPartyFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = LocalParty::class;

    public function definition()
    {
        return [
            'name' => 'Lokale partij',
        ];
    }

    public function forTownship(Township $township = null): Factory
    {
        return $this->for($township ?? Township::factory(), 'township');
    }
}

