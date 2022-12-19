<?php

namespace Vng\DennisCore\Services\GeoApi;

abstract class NationalGeoRegisterApiService extends GeoApiService
{
    public static function getDefaultQueryParameters(): array
    {
        return [
            'request' => 'GetFeature',
            'service' => 'WFS',
            'version' => '2.0.0',
            'typeName' => '',
            'outputFormat' => 'json',
//                'count' => '100',
//                'startindex' => '0',
            'srsName' => 'EPSG:4326',
        ];
    }
}
