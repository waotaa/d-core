<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Vng\DennisCore\Models\Mutation;
use Vng\DennisCore\Repositories\MutationRepositoryInterface;

class MutationRepository extends BaseRepository implements MutationRepositoryInterface
{
    public string $model = Mutation::class;
}
