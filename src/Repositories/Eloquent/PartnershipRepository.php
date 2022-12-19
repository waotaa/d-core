<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\PartnershipCreateRequest;
use Vng\DennisCore\Http\Requests\PartnershipUpdateRequest;
use Vng\DennisCore\Models\Partnership;
use Vng\DennisCore\Repositories\PartnershipRepositoryInterface;

class PartnershipRepository extends BaseRepository implements PartnershipRepositoryInterface
{
    use SoftDeletableRepository;

    public string $model = Partnership::class;

    public function new(): Partnership
    {
        return new $this->model;
    }

    public function create(PartnershipCreateRequest $request): Partnership
    {
        return $this->saveFromRequest($this->new(), $request);
    }

    public function update(Partnership $partnership, PartnershipUpdateRequest $request): Partnership
    {
        return $this->saveFromRequest($partnership, $request);
    }

    public function saveFromRequest(Partnership $partnership, FormRequest $request): Partnership
    {
        $partnership = $partnership->fill([
            'name' => $request->input('name'),
        ]);
        $partnership->save();
        return $partnership;
    }

    public function attachTownships(Partnership $partnership, string|array $townshipIds): Partnership
    {
        $partnership->townships()->syncWithoutDetaching((array) $townshipIds);
        return $partnership;
    }

    public function detachTownships(Partnership $partnership, string|array $townshipIds): Partnership
    {
        $partnership->townships()->detach((array) $townshipIds);
        return $partnership;
    }
}
