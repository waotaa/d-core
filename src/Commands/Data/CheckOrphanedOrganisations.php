<?php

namespace Vng\DennisCore\Commands\Data;

use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Repositories\LocalPartyRepositoryInterface;
use Vng\DennisCore\Repositories\NationalPartyRepositoryInterface;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;
use Vng\DennisCore\Repositories\PartnershipRepositoryInterface;
use Vng\DennisCore\Repositories\RegionalPartyRepositoryInterface;

class CheckOrphanedOrganisations extends Command
{
    protected $signature = 'data:orphaned-organisations {--fix : Remove orphaned organisations}';
    protected $description = 'Looks for orphaned organisations';

    public function __construct(
        protected OrganisationRepositoryInterface $organisationRepository,
        protected LocalPartyRepositoryInterface $localPartyRepository,
        protected PartnershipRepositoryInterface $partnershipRepository,
        protected RegionalPartyRepositoryInterface $regionalPartyRepository,
        protected NationalPartyRepositoryInterface $nationalPartyRepository,
    ) {
        parent::__construct();
    }

    public function handle(): int
    {
        $this->getOutput()->writeln('Starting check for orphaned organisations...');

        $organisations = $this->organisationRepository->builderWithTrashed()->get();
        $orphanedOrganisations = $organisations->filter(function ($organisation) {
            return !$this->isOrganisationLinked($organisation->id);
        });

        if ($orphanedOrganisations->isEmpty()) {
            $this->getOutput()->writeln('No orphaned organisations found.');
        } else {
            $this->displayOrphanedOrganisations($orphanedOrganisations);

            if ($this->option('fix')) {
                $this->deleteOrphanedOrganisations($orphanedOrganisations);
            }
        }

        $this->getOutput()->writeln('Check for orphaned organisations finished!');
        return 0;
    }

    protected function isOrganisationLinked($organisationId): bool
    {
        return $this->localPartyRepository->builderWithTrashed()->where('organisation_id', $organisationId)->exists()
            || $this->regionalPartyRepository->builderWithTrashed()->where('organisation_id', $organisationId)->exists()
            || $this->nationalPartyRepository->builderWithTrashed()->where('organisation_id', $organisationId)->exists()
            || $this->partnershipRepository->builderWithTrashed()->where('organisation_id', $organisationId)->exists();
    }

    protected function displayOrphanedOrganisations(Collection $orphanedOrganisations): void
    {
        $this->getOutput()->writeln('Orphaned organisations found:');
        foreach ($orphanedOrganisations as $organisation) {
            $this->getOutput()->writeln("- Organisation ID: {$organisation->id}");
        }
    }

    protected function deleteOrphanedOrganisations(Collection $orphanedOrganisations): void
    {
        $orphanedOrganisations->each(function (Organisation $organisation) {
            Organisation::withoutEvents(function () use ($organisation) {
                $this->organisationRepository->forceDelete($organisation->id);
            });
            $this->getOutput()->writeln("Deleted organisation ID: {$organisation->id}");
        });
    }

}
