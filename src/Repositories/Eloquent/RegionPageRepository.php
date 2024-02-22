<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\RegionPageCreateRequest;
use Vng\DennisCore\Http\Requests\RegionPageUpdateRequest;
use Vng\DennisCore\Models\RegionPage;
use Vng\DennisCore\Repositories\RegionPageRepositoryInterface;

class RegionPageRepository extends BaseRepository implements RegionPageRepositoryInterface
{
    use SoftDeletableRepository;

    protected string $model = RegionPage::class;

    public function new(): RegionPage
    {
        return new $this->model;
    }

    public function create(RegionPageCreateRequest $request): RegionPage
    {
        return $this->saveFromRequest($this->new(), $request);
    }

    public function update(RegionPage $regionPage, RegionPageUpdateRequest $request): RegionPage
    {
        return $this->saveFromRequest($regionPage, $request);
    }

    public function saveFromRequest(RegionPage $regionPage, FormRequest $request): RegionPage
    {
        $regionPage = $regionPage->fill([
            'description' => $request->input('description'),
            'cooperation_partners' => $request->input('cooperation_partners'),
            'additional_information' => $request->input('additional_information'),
            'terminology' => $request->input('terminology'),
        ]);
        $regionPage->region()->associate($request->input('region_id'));
        if ($request->has('regional_party_id')) {
            $regionPage->regionalParty()->associate($request->input('regional_party_id'));
        } else {
            $regionPage->regionalParty()->disassociate();
        }
        $regionPage->save();
        return $regionPage;
    }

    public function attachContacts(RegionPage $regionPage, string|array $contactIds): RegionPage
    {
        $regionPage->contacts()->syncWithoutDetaching((array) $contactIds);
        return $regionPage;
    }

    public function detachContacts(RegionPage $regionPage, string|array $contactIds): RegionPage
    {
        $regionPage->contacts()->detach((array) $contactIds);
        return $regionPage;
    }
}
