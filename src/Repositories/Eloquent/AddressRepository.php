<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\AddressCreateRequest;
use Vng\DennisCore\Http\Requests\AddressUpdateRequest;
use Vng\DennisCore\Models\Address;
use Vng\DennisCore\Repositories\AddressRepositoryInterface;

class  AddressRepository extends BaseRepository implements AddressRepositoryInterface
{
    public string $model = Address::class;

    public function create(AddressCreateRequest $request): Address
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Address $download, AddressUpdateRequest $request): Address
    {
        return $this->saveFromRequest($download, $request);
    }

    public function saveFromRequest(Address $address, FormRequest $request): Address
    {
        $organisationRepository = new OrganisationRepository();
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new \Exception('invalid organisation provided');
        }

        $address->fill([
            'name' => $request->input('name'),
            'straatnaam' => $request->input('straatnaam'),
            'huisnummer' => $request->input('huisnummer'),
            'postbusnummer' => $request->input('postbusnummer'),
            'antwoordnummer' => $request->input('antwoordnummer'),
            'postcode' => $request->input('postcode'),
            'woonplaats' => $request->input('woonplaats'),
        ]);
        $address->organisation()->associate($organisation);

        $address->save();
        return $address;
    }
}
