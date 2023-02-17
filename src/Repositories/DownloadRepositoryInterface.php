<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\DownloadCreateRequest;
use Vng\DennisCore\Http\Requests\DownloadUpdateRequest;
use Vng\DennisCore\Models\Download;

interface DownloadRepositoryInterface extends InstrumentOwnedEntityRepositoryInterface
{
    public function create(DownloadCreateRequest $request): Download;
    public function update(Download $download, DownloadUpdateRequest $request): Download;
}
