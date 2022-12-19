<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\Provider;

class ProviderFactory extends Factory
{
    use OrganisationOwnedTrait;

    /**
     * @var string
     */
    protected $model = Provider::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
        ];
    }
}
