<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Vng\DennisCore\Enums\TileEnum;
use Vng\DennisCore\Models\Tile;

class TileFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Tile::class;

    public function definition(): array
    {
        return [
            'name' => collect(TileEnum::toArray())->random(),
        ];
    }
}
