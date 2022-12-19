<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\NeighbourhoodCreateRequest;
use Vng\DennisCore\Http\Requests\NeighbourhoodUpdateRequest;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Repositories\NeighbourhoodRepositoryInterface;

class NeighbourhoodRepository extends BaseRepository implements NeighbourhoodRepositoryInterface
{
    public string $model = Neighbourhood::class;

    public function create(NeighbourhoodCreateRequest $request): Neighbourhood
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Neighbourhood $neighbourhood, NeighbourhoodUpdateRequest $request): Neighbourhood
    {
        return $this->saveFromRequest($neighbourhood, $request);
    }

    public function saveFromRequest(Neighbourhood $neighbourhood, FormRequest $request): Neighbourhood
    {
        $neighbourhood->fill([
            'name' => $request->input('name'),
        ]);
        $neighbourhood->township()->associate($request->input('township_id'));
        $neighbourhood->save();
        return $neighbourhood;
    }
}
