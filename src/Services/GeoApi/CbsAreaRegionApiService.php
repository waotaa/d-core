<?php

namespace Vng\DennisCore\Services\GeoApi;

use GuzzleHttp\Client;
use Illuminate\Support\Str;

class CbsAreaRegionApiService extends NationalGeoRegisterApiService
{
    const FILENAME = 'cbs-area-region';

    public static function getFileName()
    {
        return self::FILENAME;
    }

    public static function fetchApiContents($includeGeo = false): string
    {
        $properties = [
            'statcode',
            'statnaam'
        ];
        if ($includeGeo) {
            $properties[] = 'geom';
        }

        $client = new Client(['base_uri' => 'https://geodata.nationaalgeoregister.nl']);
        $response = $client->request('GET', 'cbsgebiedsindelingen/wfs', [
            'query' => array_merge(NationalGeoRegisterApiService::getDefaultQueryParameters(), [
                'typeName' => 'cbsgebiedsindelingen:cbs_arbeidsmarktregio_2020_gegeneraliseerd',
                'propertyName' => join(',', $properties),
            ])
        ]);

        return $response->getBody()->getContents();
    }

    public static function getFormattedData(array $data)
    {
        return array_map(function($entry) {
            return [
                'code' => $entry['properties']['statcode'],
                'name' => $entry['properties']['statnaam'],
                'slug' => Str::slug($entry['properties']['statnaam']),
            ];
        }, $data);
    }
}
