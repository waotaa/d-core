<?php

namespace Vng\DennisCore\Services\GeoComparison;

use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Services\GeoData\BasicTownshipModel;
use Vng\DennisCore\Services\GeoData\TownshipDataService;
use Illuminate\Support\Collection;

class TownshipDataComparisonService extends GeoDataComparisonService
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
        return Township::all()->map(
            fn (Township $township) => BasicTownshipModel::createFromSource($township)
        );
    }

    public static function getSourceCollection(): Collection
    {
        $data = TownshipDataService::loadSourceData();
        return TownshipDataService::createBasicGeoCollectionFromData($data);
    }

    public function getDeviations(array $attributes = null)
    {
        $coupleCollection = collect();
        $this->collectionB->each(function(BasicTownshipModel $comparisonTownship) use ($coupleCollection, $attributes) {
            $currentTownship = static::getItemByCode($this->collectionA, $comparisonTownship->getCode());
            $comparison = TownshipComparison::create($currentTownship, $comparisonTownship, $attributes);
            if ($comparison->hasDeviations()) {
                $coupleCollection->add($comparison);
            }
        });

        $this->findItemsNotInCollectionB()->each(function(BasicTownshipModel $currentTownship) use ($coupleCollection, $attributes) {
            $coupleCollection->add(TownshipComparison::create($currentTownship, null, $attributes));
        });

        return $coupleCollection;
    }
}
