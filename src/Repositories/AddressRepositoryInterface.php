<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\AddressCreateRequest;
use Vng\DennisCore\Http\Requests\AddressUpdateRequest;
use Vng\DennisCore\Models\Address;

interface AddressRepositoryInterface extends BaseRepositoryInterface
{
    public function create(AddressCreateRequest $request): Address;
    public function update(Address $download, AddressUpdateRequest $request): Address;
}
