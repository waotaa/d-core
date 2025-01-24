<?php

namespace Vng\DennisCore\Observers;

use Illuminate\Support\Facades\Log;
use Vng\DennisCore\Models\AbstractOrganisationBase;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;

class OrganisationObserver
{
    public function __construct(
        protected OrganisationRepositoryInterface $organisationRepository
    )
    {}

    public function deleting(Organisation $model)
    {
        if ($model->isForceDeleting()) {
            Log::debug('hard deleting organisation');
        } else {
            Log::debug('soft deleting organisation');
        }
        if (!$model->isCascadingDelete) {
            // The deletion originated from the OrganisationEntity and needs to cascade to the organisation

            /** @var AbstractOrganisationBase $organisationEntity */
            $organisationEntity = $model->organisation_variant;

            if ($organisationEntity) {
                // flag the organisation entity that the deletion performed on it originated here, so it does not need to cascade back
                $organisationEntity->isCascadingDelete = true;

                if ($model->isForceDeleting()) {
                    Log::debug('cascade hard delete to organisation entity');
                    $organisationEntity->forceDelete();
                } else {
                    Log::debug('cascade soft delete to organisation entity');
                    $organisationEntity->delete();
                }
            }
        }
    }

    public function restoring(Organisation $model)
    {
        if (!$model->isCascadingRestore) {
            // The restoration originated from the OrganisationEntity and needs to cascade to the organisation

            /** @var AbstractOrganisationBase $organisationEntity */
            $organisationEntity = $model->organisation_variant;
            if ($organisationEntity) {
                // flag the organisation entity that the restoration performed on it originated here, so it does not need to cascade back
                $organisationEntity->isCascadingRestore = true;

                $organisationEntity->restore();
            }
        }
    }
}
