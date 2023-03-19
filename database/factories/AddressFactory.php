<?php

namespace Database\Factories;

use Vng\DennisCore\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    use OrganisationOwnedTrait;

    /**
     * @var string
     */
    protected $model = Address::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'straatnaam' => $this->faker->streetName,
            'huisnummer' => $this->faker->randomNumber(3),
            'postcode' => $this->faker->postcode,
            'woonplaats' => $this->faker->city,
            'addressable_type' => 1,
            'addressable_id' => 1,
        ];
    }
}
