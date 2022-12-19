<?php

namespace Vng\DennisCore\Services\GeoComparison;

use Vng\DennisCore\Services\GeoData\BasicTownshipModel;

class TownshipComparison extends GeoComparison
{
    const COMPARABLE_ATTRIBUTES = [
        'name',
        'slug',
        'region_code'
    ];

    public function __construct(BasicTownshipModel $modelA = null, BasicTownshipModel $modelB = null, array $attributes = null)
    {
        parent::__construct($modelA, $modelB, $attributes);
    }
}
