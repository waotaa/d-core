<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Vng\DennisCore\Repositories\BaseRepositoryInterface;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected string $model;

    public function builder(): Builder
    {
        return $this->model::query();
    }

    public function all(): Collection
    {
        return $this->model::all();
    }

    public function index(int $perPage = 10): LengthAwarePaginator
    {
        return $this->builder()
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    public function find($id): ?Model
    {
        return $this->model::find($id);
    }

    public function findMany(array $ids): Collection
    {
        return $this
            ->builder()
            ->whereIn('id', $ids)
            ->get();
    }

    public function new(): Model
    {
        return new $this->model();
    }

    public function delete(string $id): ?bool
    {
        $model = $this->find($id);
        return $model->delete();
    }
}
