<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\RegionalPartyCreateRequest;
use Vng\DennisCore\Http\Requests\RegionalPartyUpdateRequest;
use Vng\DennisCore\Models\RegionalParty;
use Vng\DennisCore\Repositories\RegionalPartyRepositoryInterface;

class RegionalPartyRepository extends BaseRepository implements RegionalPartyRepositoryInterface
{
    use SoftDeletableRepository;

    protected string $model = RegionalParty::class;

    public function new(): RegionalParty
    {
        return new $this->model;
    }

    public function create(RegionalPartyCreateRequest $request): RegionalParty
    {
        return $this->saveFromRequest($this->new(), $request);
    }

    public function update(RegionalParty $regionalParty, RegionalPartyUpdateRequest $request): RegionalParty
    {
        return $this->saveFromRequest($regionalParty, $request);
    }

    public function saveFromRequest(RegionalParty $regionalParty, FormRequest $request): RegionalParty
    {
        $regionalParty = $regionalParty->fill([
            'name' => $request->input('name'),
        ]);
        $regionalParty->region()->associate($request->input('region_id'));
        $regionalParty->save();
        return $regionalParty;
    }
}
