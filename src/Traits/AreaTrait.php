<?php

namespace Vng\DennisCore\Traits;

use Illuminate\Support\Collection;
use ReflectionClass;
use Vng\DennisCore\Interfaces\AreaInterface;
use Vng\DennisCore\Services\AreaService;

trait AreaTrait
{
    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
//        return get_class($this);
        return (new ReflectionClass($this))->getShortName();
    }

    public function getAreaIdentifier(): string
    {
        return $this->getType() . '-' . $this->getName();
    }

    public function getOwnAreas(): Collection
    {
        return collect([$this]);
    }

    public function getAreasLocatedIn(): Collection
    {
        $areasLocatedIn = $this->getOwnAreas();

        if ($this->getParentAreas()) {
            $this->getParentAreas()
                ->filter()
                ->map(fn (AreaInterface $area) => $area->getAreasLocatedIn())
                ->flatten()
                ->each(fn (AreaInterface $area) => $areasLocatedIn->add($area));
        }

        return AreaService::removeDuplicateAreas($areasLocatedIn);
    }

    public function getContainingAreas(): Collection
    {
        $containingAreas = $this->getOwnAreas();

        if ($this->getChildAreas()) {
            $this->getChildAreas()
                ->filter()
                ->map(fn (AreaInterface $area) => $area->getContainingAreas())
                ->flatten()
                ->each(fn (AreaInterface $area) => $containingAreas->add($area));
        }

        return AreaService::removeDuplicateAreas($containingAreas);
    }

    public function getEncompassingAreas(): Collection
    {
        $locatedIn = $this->getAreasLocatedIn();
        $containing = $this->getContainingAreas();
        $areas = collect()->concat($locatedIn)->concat($containing);
        return AreaService::removeDuplicateAreas($areas);
    }
}

