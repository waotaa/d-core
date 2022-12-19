<?php


namespace Vng\DennisCore\Services\ModelHelpers;

use Vng\DennisCore\Models\Instrument;
use DateTime;
use Illuminate\Database\Eloquent\Builder;

class InstrumentHelper
{
    private Instrument $instrument;

    public function __construct(Instrument $instrument)
    {
        $this->instrument = $instrument;
    }

    public static function create(Instrument $instrument): InstrumentHelper
    {
        return new static($instrument);
    }

    public function isPublished(): bool
    {
        $is_active = $this->instrument->getAttribute('is_active');
        if (!$is_active) {
            return false;
        }

        if (!$this->isComplete()) {
            return false;
        }

        $today = (new DateTime())->setTime(0, 0);
        $publishFrom = $this->instrument->getAttribute('publish_from');
        if (!is_null($publishFrom) && $publishFrom >= $today) {
            return false;
        }

        $publishTo = $this->instrument->getAttribute('publish_to');
        if (!is_null($publishTo) && $publishTo < $today) {
            return false;
        }
        return true;
    }

    public function isComplete(): bool
    {
        return $this->hasTile()
            && $this->hasTargetGroup();
    }

    public function hasProvider(): bool
    {
        return $this->instrument->providers()->count() > 0;
    }

    public function hasTile(): bool
    {
        return $this->instrument->tiles()->count() > 0;
    }

    public function hasTargetGroup(): bool
    {
        return $this->instrument->targetGroups()->count() > 0;
    }

    public static function queryPublished(Builder $builder): Builder
    {
        return $builder->where(function (Builder $builder) {
            $today = (new DateTime())->setTime(0, 0);
            $builder
                ->where('is_active', true)
                ->where(function (Builder $builder) use ($today) {
                    return $builder
                        ->whereNull('publish_from')
                        ->orWhereDate('publish_from', '<=', $today);
                })
                ->where(function (Builder $builder) use ($today) {
                    return $builder
                        ->whereNull('publish_to')
                        ->orWhereDate('publish_to', '>', $today);
                });
        });
    }

    public static function queryUnpublished(Builder $builder): Builder
    {
        return $builder->where(function (Builder $builder) {
            $today = (new DateTime())->setTime(0, 0);
            $builder
                ->where('is_active', false)
                ->orWhere(function (Builder $builder) use ($today) {
                    return $builder
                        ->whereNotNull('publish_from')
                        ->whereDate('publish_from', '>', $today);
                })
                ->orWhere(function (Builder $builder) use ($today) {
                    return $builder
                        ->whereNotNull('publish_to')
                        ->whereDate('publish_to', '<', $today);
                });
        });
    }

    public static function queryComplete(Builder $builder): Builder
    {
        return $builder
            ->has('tiles')
            ->has('targetGroups');
    }

    public static function queryIncomplete(Builder $builder): Builder
    {
        return $builder
            ->doesntHave('tiles')
            ->orDoesntHave('targetGroups');
    }
}
