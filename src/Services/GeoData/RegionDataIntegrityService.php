<?php

namespace Vng\DennisCore\Services\GeoData;

use Vng\DennisCore\Models\Region;
use Illuminate\Support\Collection;

class RegionDataIntegrityService
{
    public static function checkAllRegionsHaveCode(): Collection
    {
        $noCodeRegions = Region::query()->where('code', '')->get();
        $noCodeRegions->each(function(Region $region) {
            $regionData = RegionDataService::findRegionByLegacySlug($region->slug);
            if (is_null($regionData)) {
                return;
            }

            $region->code = $regionData['code'];
            $region->save();
        });
        return $noCodeRegions;
    }
}
