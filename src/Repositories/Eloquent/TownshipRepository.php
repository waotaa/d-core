<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Vng\DennisCore\Models\Township;
use Vng\DennisCore\Repositories\TownshipRepositoryInterface;

class TownshipRepository extends BaseRepository implements TownshipRepositoryInterface
{
    public string $model = Township::class;

    public function attachPartnerships(Township $township, string|array $partnershipIds): Township
    {
        $township->partnerships()->syncWithoutDetaching((array) $partnershipIds);
        return $township;
    }

    public function detachPartnerships(Township $township, string|array $partnershipIds): Township
    {
        $township->partnerships()->detach((array) $partnershipIds);
        return $township;
    }
}
