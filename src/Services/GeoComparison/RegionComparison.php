<?php

namespace Vng\DennisCore\Services\GeoComparison;

use Vng\DennisCore\Services\GeoData\BasicRegionModel;

class RegionComparison extends GeoComparison
{
    const COMPARABLE_ATTRIBUTES = [
        'name',
        'slug',
        'color'
    ];

    public function __construct(BasicRegionModel $modelA = null, BasicRegionModel $modelB = null, array $attributes = null)
    {
        parent::__construct($modelA, $modelB, $attributes);
    }
}
