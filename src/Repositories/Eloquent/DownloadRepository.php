<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Vng\DennisCore\Http\Requests\DownloadCreateRequest;
use Vng\DennisCore\Http\Requests\DownloadUpdateRequest;
use Vng\DennisCore\Models\Download;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Repositories\DownloadRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Services\DownloadsService;

class DownloadRepository extends BaseRepository implements DownloadRepositoryInterface
{
    use InstrumentOwnedEntityRepository;

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
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        /** @var Instrument $instrument */
        $instrument = $instrumentRepository->find($request->input('instrument_id'));
        if (is_null($instrument)) {
            throw new \Exception('invalid instrument provided');
        }
        $organisation = $instrument->organisation;
        if (is_null($organisation)) {
            throw new \Exception('instrument requires an organisation');
        }

        if ($request->has('file')) {
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $request->file('file');
            $download = DownloadsService::saveUploadedFile($uploadedFile, $organisation, $download);
        } elseif ($request->has('key')) {
            $download = DownloadsService::movePreUploadedFile($request->input('key'), $organisation, $download);
            $download->fill([
                'filename' => $request->input('filename'),
            ]);
        } else {
            throw new \Exception('Invalid request. Missing file or key');
        }

        $download->fill([
            'label' => $request->input('label'),
        ]);
        $download->instrument()->associate($request->input('instrument_id'));
        $download->save();
        return $download;
    }
}
