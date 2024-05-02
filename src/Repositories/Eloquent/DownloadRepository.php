<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Gate;
use Vng\DennisCore\Http\Requests\DownloadCreateRequest;
use Vng\DennisCore\Http\Requests\DownloadUpdateRequest;
use Vng\DennisCore\Models\Download;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Repositories\DownloadRepositoryInterface;
use Vng\DennisCore\Repositories\InstrumentRepositoryInterface;
use Vng\DennisCore\Services\DownloadsService;

class DownloadRepository extends BaseRepository implements DownloadRepositoryInterface
{
    use OwnedEntityRepository;

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
        $organisationRepository = new OrganisationRepository();
        /** @var Organisation $organisation */
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new \Exception('invalid organisation provided');
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
        $download->organisation()->associate($organisation);
        $download->save();
        return $download;
    }

    public function attachInstruments(Download $download, string|array $instrumentIds): Download
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($download) {
                    Gate::authorize('attachInstrument', [$download, $instrument]);
                }
            );

        $download->instruments()->syncWithoutDetaching($instrumentIds);
        return $download;
    }

    public function detachInstruments(Download $download, string|array $instrumentIds): Download
    {
        $instrumentIds = (array) $instrumentIds;
        /** @var InstrumentRepositoryInterface $instrumentRepository */
        $instrumentRepository = app(InstrumentRepositoryInterface::class);
        $instrumentRepository
            ->findMany($instrumentIds)
            ->each(
                function (Instrument $instrument) use ($download) {
                    Gate::authorize('detachInstrument', [$download, $instrument]);
                }
            );

        $download->instruments()->detach($instrumentIds);
        return $download;
    }
}
