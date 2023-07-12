<?php

namespace Vng\DennisCore\Commands\Format;

use Illuminate\Database\Eloquent\Builder;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Provider;
use Illuminate\Console\Command;
use Vng\DennisCore\Repositories\ContactRepositoryInterface;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;

class ContactsMatchOrganisations extends Command
{
    protected $signature = 'format:match-contacts';
    protected $description = 'Matches contacts with organisations to set as it\'s owner';

    public function __construct(
        protected ContactRepositoryInterface $contactRepository,
        protected OrganisationRepositoryInterface $organisationRepository
    ){
        parent::__construct();
    }

    public function handle(): int
    {
        $this->output->writeln('match contacts...');
        $this->matchContacts();

        $this->output->writeln('match contacts finished');
        return 0;
    }

    protected function matchContacts()
    {
        $contacts = $this->contactRepository->builder()
            ->whereDoesntHave('organisation')
            ->where(function(Builder $query) {
                $query
                    ->whereHas('instruments')
                    ->orWhereHas('providers');
            })
            ->get();
        $this->output->writeln($contacts->count() . ' contacts found');
        $contacts->each(function (Contact $contact) {
            $this->output->writeln('contact ' . $contact->id);
            $instrumentOrgIds = $contact?->instruments->map(fn (Instrument $i) => $i->organisation?->id);
            $instrumentOrgIds = $instrumentOrgIds->filter();
            $this->output->writeln('ins org ids ' . $instrumentOrgIds->join(', '));
            $providerOrgIds = $contact?->providers->map(fn (Provider $p) => $p->organisation?->id);
            $providerOrgIds = $providerOrgIds->filter();
            $this->output->writeln('prv org ids ' . $providerOrgIds->join(', '));
            $orgIds = array_merge($instrumentOrgIds->toArray(), $providerOrgIds->toArray());
            $this->output->writeln('org ids' . join(', ', $orgIds));

            $orgIds = array_unique($orgIds);
            if (count($orgIds) === 1) {
                $id = reset($orgIds);
                $org = $this->organisationRepository->find($id);
                $this->output->info('Only 1 org found connected! ' . $org->identifier);
                
                $contact->organisation()->associate($org->id);
                $contact->saveQuietly();
            } else if (count($orgIds) > 1) {
                $this->output->warning('More than 1 org found: ' . join(', ', $orgIds));
            }
        });
    }
}
