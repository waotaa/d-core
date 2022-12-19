<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Http\Requests\VideoCreateRequest;
use Vng\DennisCore\Http\Requests\VideoUpdateRequest;
use Vng\DennisCore\Models\Video;

interface VideoRepositoryInterface extends BaseRepositoryInterface
{
    public function create(VideoCreateRequest $request): Video;
    public function update(Video $download, VideoUpdateRequest $request): Video;
}
