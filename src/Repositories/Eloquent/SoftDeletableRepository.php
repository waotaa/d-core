<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

trait SoftDeletableRepository
{
    public function trashed(): Collection
    {
        return $this->model::onlyTrashed()->get();
    }

    public function builderOnlyTrashed(): Builder
    {
        return $this->model::onlyTrashed();
    }

    public function findInTrashed(string $id): ?Model
    {
        return $this->model::onlyTrashed()->find($id);
    }

    public function findWithTrashed(string $id): ?Model
    {
        return $this->model::withTrashed()->find($id);
    }

    public function builderWithTrashed(): Builder
    {
        return $this->model::withTrashed();
    }

    public function restore(string $id): ?Model
    {
        $model = $this->findInTrashed($id);
        $model->restore();
        return $model;
    }

    public function forceDelete(string $id): ?bool
    {
        $model = $this->findWithTrashed($id);
        return $model->forceDelete();
    }
}
