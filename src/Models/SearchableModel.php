<?php

namespace Vng\DennisCore\Models;

use Vng\DennisCore\Interfaces\SearchableInterface;
use Vng\DennisCore\Observers\ElasticsearchObserver;
use Illuminate\Database\Eloquent\Model;

abstract class SearchableModel extends Model implements SearchableInterface
{
    protected string $elasticResource;

    protected static function boot()
    {
        parent::boot();
        static::observe(ElasticsearchObserver::class);
    }

    public function getSearchIndex()
    {
        return $this->getTable();
    }

    public function getSearchType()
    {
        if (property_exists($this, 'useSearchType')) {
            return $this->useSearchType;
        }

        return $this->getTable();
    }

    public function getResourceClass()
    {
        return $this->elasticResource;
    }

    public function getSearchId()
    {
        return $this->getKey();
    }

    public function toSearchArray()
    {
        $resource = $this->elasticResource::make($this);
        return $resource->toArray();
    }
}
