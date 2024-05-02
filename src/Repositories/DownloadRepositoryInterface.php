<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\DownloadCreateRequest;
use Vng\DennisCore\Http\Requests\DownloadUpdateRequest;
use Vng\DennisCore\Models\Download;

interface DownloadRepositoryInterface extends OwnedEntityRepositoryInterface
{
    public function create(DownloadCreateRequest $request): Download;
    public function update(Download $download, DownloadUpdateRequest $request): Download;

    public function attachInstruments(Download $download, string|array $instrumentIds): Download;
    public function detachInstruments(Download $download, string|array $instrumentIds): Download;
}
