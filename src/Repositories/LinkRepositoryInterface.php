<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\LinkCreateRequest;
use Vng\DennisCore\Http\Requests\LinkUpdateRequest;
use Vng\DennisCore\Models\Link;

interface LinkRepositoryInterface extends InstrumentOwnedEntityRepositoryInterface
{
    public function create(LinkCreateRequest $request): Link;
    public function update(Link $download, LinkUpdateRequest $request): Link;
}
