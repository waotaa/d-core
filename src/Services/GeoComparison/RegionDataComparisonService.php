<?php

namespace Vng\DennisCore\Services\GeoComparison;

use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Services\GeoData\BasicRegionModel;
use Vng\DennisCore\Services\GeoData\RegionDataService;
use Illuminate\Support\Collection;

class RegionDataComparisonService extends GeoDataComparisonService
{
    public static function createWithDatabaseCollection(Collection $comparisonCollection)
    {
        return new static(static::getDatabaseCollection(), $comparisonCollection);
    }

    public static function createWithSourceCollection(Collection $comparisonCollection)
    {
        return new static(static::getSourceCollection(), $comparisonCollection);
    }

    public static function getDatabaseCollection()
    {
        return Region::all()->map(
            fn (Region $region) => BasicRegionModel::createFromSource($region)
        );
    }

    public static function getSourceCollection(): Collection
    {
        $data = RegionDataService::loadSourceData();
        return RegionDataService::createBasicGeoCollectionFromData($data);
    }

    public function getDeviations(array $attributes = null)
    {
        $coupleCollection = collect();
        $this->collectionB->each(function(BasicRegionModel $comparisonRegion) use ($coupleCollection, $attributes) {
            $currentRegion = static::getItemByCode($this->collectionA, $comparisonRegion->getCode());
            $comparison = RegionComparison::create($currentRegion, $comparisonRegion, $attributes);
            if ($comparison->hasDeviations()) {
                $coupleCollection->add($comparison);
            }
        });

        $this->findItemsNotInCollectionB()->each(function(BasicRegionModel $currentRegion) use ($coupleCollection, $attributes) {
            $coupleCollection->add(RegionComparison::create($currentRegion, null, $attributes));
        });

        return $coupleCollection;
    }
}
