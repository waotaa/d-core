<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Vng\DennisCore\Http\Requests\LocationCreateRequest;
use Vng\DennisCore\Http\Requests\LocationUpdateRequest;
use Vng\DennisCore\Models\Location;
use Vng\DennisCore\Repositories\LocationRepositoryInterface;

class LocationRepository extends BaseRepository implements LocationRepositoryInterface
{
    protected string $model = Location::class;

    public function create(LocationCreateRequest $request): Location
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Location $location, LocationUpdateRequest $request): Location
    {
        return $this->saveFromRequest($location, $request);
    }

    public function saveFromRequest(Location $location, FormRequest $request): Location
    {
        $location->fill([
            'name' => $request->input('name'),
            'type' => $request->input('type'),
            'is_active' => $request->input('is_active'),
            'description' => $request->input('description'),
        ]);

        if (!$request->has('instrument_id')) {
            $location->instrument()->dissociate();
        }
        $location->instrument()->associate($request->input('instrument_id'));

        if (!$request->has('address_id')) {
            $location->address()->dissociate();
        }
        $location->address()->associate($request->input('address_id'));

        $location->save();
        return $location;
    }
}