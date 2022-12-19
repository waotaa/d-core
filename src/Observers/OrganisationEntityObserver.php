<?php

namespace Vng\DennisCore\Observers;

use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Repositories\Eloquent\OrganisationRepository;

class OrganisationEntityObserver
{
    public function creating(Model $model): void
    {
        $orgRepo = new OrganisationRepository();
        $organisation = $orgRepo->new();
        $organisation->save();
        $model->organisation()->associate($organisation);
    }

    public function saved(Model $model): void
    {
        // optional
        $orgRepo = new OrganisationRepository();
        $organisation = $orgRepo->associateOrganisationable($model);
        $organisation->save();
    }
}
