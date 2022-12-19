<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Vng\DennisCore\Http\Requests\DownloadCreateRequest;
use Vng\DennisCore\Http\Requests\DownloadUpdateRequest;
use Vng\DennisCore\Models\Download;
use Vng\DennisCore\Repositories\DownloadRepositoryInterface;
use Vng\DennisCore\Services\DownloadsService;

class DownloadRepository extends BaseRepository implements DownloadRepositoryInterface
{
    public string $model = Download::class;

    public function create(DownloadCreateRequest $request): Download
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Download $download, DownloadUpdateRequest $request): Download
    {
        return $this->saveFromRequest($download, $request);
    }

    public function saveFromRequest(Download $download, FormRequest $request): Download
    {
        /** @var UploadedFile $uploadedFile */
        $uploadedFile = $request->file('file');
        $download = DownloadsService::saveUploadedFile($uploadedFile, $download);
        $download->fill([
            'label' => $request->input('label'),
        ]);
        $download->instrument()->associate($request->input('instrument_id'));
        $download->save();
        return $download;
    }
}
