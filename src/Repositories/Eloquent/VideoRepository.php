<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\VideoCreateRequest;
use Vng\DennisCore\Http\Requests\VideoUpdateRequest;
use Vng\DennisCore\Models\Video;
use Vng\DennisCore\Repositories\VideoRepositoryInterface;

class VideoRepository extends BaseRepository implements VideoRepositoryInterface
{
    public string $model = Video::class;

    public function create(VideoCreateRequest $request): Video
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Video $video, VideoUpdateRequest $request): Video
    {
        return $this->saveFromRequest($video, $request);
    }

    public function saveFromRequest(Video $video, FormRequest $request): Video
    {
        $video->fill([
            'video_identifier' => $request->input('video_identifier'),
            'provider' => $request->input('provider'),
        ]);
        $video->instrument()->associate($request->input('instrument_id'));
        $video->save();
        return $video;
    }
}
