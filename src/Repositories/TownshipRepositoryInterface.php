<?php

namespace Vng\DennisCore\Repositories;

use Vng\DennisCore\Models\Township;

interface TownshipRepositoryInterface extends BaseRepositoryInterface
{
    public function attachPartnerships(Township $township, string|array $partnershipIds): Township;
    public function detachPartnerships(Township $township, string|array $partnershipIds): Township;
}
