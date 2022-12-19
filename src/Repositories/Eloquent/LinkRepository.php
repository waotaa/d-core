<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\LinkCreateRequest;
use Vng\DennisCore\Http\Requests\LinkUpdateRequest;
use Vng\DennisCore\Models\Link;
use Vng\DennisCore\Repositories\LinkRepositoryInterface;

class LinkRepository extends BaseRepository implements LinkRepositoryInterface
{
    public string $model = Link::class;

    public function create(LinkCreateRequest $request): Link
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Link $link, LinkUpdateRequest $request): Link
    {
        return $this->saveFromRequest($link, $request);
    }

    public function saveFromRequest(Link $link, FormRequest $request): Link
    {
        $link->fill([
            'label' => $request->input('label'),
            'url' => $request->input('url'),
        ]);
        $link->instrument()->associate($request->input('instrument_id'));
        $link->save();
        return $link;
    }
}
