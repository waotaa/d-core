<?php

namespace Database\Factories;

use Vng\DennisCore\Models\Instrument;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstrumentFactory extends Factory
{
    use OrganisationOwnedTrait;

    /**
     * @var string
     */
    protected $model = Instrument::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'is_active' => true,
            'is_leerwerktraject' => false,
        ];
    }
}
