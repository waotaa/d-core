<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Models\Partnership;

class PartnershipFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Partnership::class;

    public function definition()
    {
        return [
            'name' => 'Samenwerkingsverband',
            'slug' => 'samenwerkingsverband',
        ];
    }
}
