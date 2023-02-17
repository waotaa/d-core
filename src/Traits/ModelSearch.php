<?php

namespace Vng\DennisCore\Traits;

use Illuminate\Database\Eloquent\Builder;

trait ModelSearch
{
    public array $searchableProps = [];

    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where(function(Builder $query) use ($search) {
            $model = $query->getModel();

            $connectionType = $model->getConnection()->getDriverName();

            $canSearchPrimaryKey = ctype_digit($search) &&
                in_array($model->getKeyType(), ['int', 'integer']) &&
                ($connectionType != 'pgsql' || $search <= static::maxPrimaryKeySize()) &&
                in_array($model->getKeyName(), $this->searchableProps);

            if ($canSearchPrimaryKey) {
                $query->orWhere($model->getQualifiedKeyName(), $search);
            }

            $likeOperator = $connectionType == 'pgsql' ? 'ilike' : 'like';

            foreach ($this->searchableProps as $prop) {
                $query->orWhere(
                    $model->qualifyColumn($prop),
                    $likeOperator,
                    '%'.$search.'%'
                );
            }
        });
    }
}