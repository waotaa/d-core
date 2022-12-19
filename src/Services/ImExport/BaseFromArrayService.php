<?php

namespace Vng\DennisCore\Services\ImExport;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Models\LocalParty;
use Vng\DennisCore\Models\NationalParty;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\RegionalParty;
use Vng\DennisCore\Models\Township;
use Exception;

abstract class BaseFromArrayService
{
    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public static function create(array $data): Model
    {
        $service = new static($data);
        return $service->handle();
    }

    abstract public function handle(): Model;

    public static function findOwner($ownerData)
    {
        if (is_null($ownerData)) {
            return null;
        }

        switch ($ownerData['type']) {
            case 'Township':
                return Township::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->first();
            case 'Local Party':
                return LocalParty::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->firstOrCreate();
            case 'Region':
                return Region::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->first();
            case 'Regional Party':
                return RegionalParty::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->first();
            case 'National Party':
                return NationalParty::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->first();
            case 'Partnership':
                return Partnership::query()->where([
                    'slug' => $ownerData['slug'],
//                    'name' => $organisationData['name'],
                ])->firstOrCreate();
            default:
                throw new Exception('no owner found');
        }
    }

    public static function addOrganisationDataToChildProperty($data, $property)
    {
        $organisation = $data['organisation'];
        if (is_null($organisation)) {
            return $data;
        }

        $data[$property] = array_map(function ($child) use ($organisation) {
            $child['organisation'] = $organisation;
            return $child;
        }, $data[$property]);

        return $data;
    }
}