<?php

namespace Vng\DennisCore\Commands\Operations;

use Vng\DennisCore\Enums\ContactTypeEnum;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Models\Region;
use Illuminate\Console\Command;

class CleanContacts extends Command
{
    protected $signature = 'operation:clean-contacts';
    protected $description = 'Merges duplicate contacts';

    public function handle(): int
    {
        $this->output->writeln('clean contacts...');
        $this->cleanAllContacts();
        $this->scanUntilNoDuplicates();
        $this->reallocateTypeAttributeToPivot();
        $this->output->writeln('clean contacts finished');
        return 0;
    }

    protected function cleanAllContacts()
    {
        Contact::all()->each(function (Contact $contact) {
            $cleanName = trim($contact->name);
            $nameIsClean = $cleanName === $contact->name;
            $cleanPhone = preg_replace('/[\s-]/', '', $contact->phone);
            $phoneIsClean = $cleanPhone === $contact->phone;
            $cleanEmail = trim($contact->email);
            $emailIsClean = $cleanEmail === $contact->email;

            if (!$nameIsClean || !$phoneIsClean || !$emailIsClean) {
                $contact->name = $cleanName;
                $contact->phone = $cleanPhone;
                $contact->email = $cleanEmail;
                $contact->save();
            }
        });
    }

    protected function scanUntilNoDuplicates()
    {
        $noDuplicates = $this->scanAllContacts();
        if (!$noDuplicates) {
            $this->scanUntilNoDuplicates();
        }
    }

    protected function scanAllContacts(): bool
    {
        $contacts = Contact::all();
        $this->output->info('Scan');
        $this->output->writeln($contacts->count() . ' found');
        $this->output->newLine();

        foreach ($contacts as $contact) {
            $duplicates = Contact::query()
                ->where('id', '!=', $contact->id)
                ->where([
                    'name' => $contact->name,
                    'phone' => $contact->phone,
                    'email' => $contact->email,
//                    'type' => $contact->type ? $contact->type->getKey() : null,
                ])
                ->get();

            if ($duplicates->count() === 0) {
                $this->output->write('-');
            }

            if ($duplicates->count()) {
                $this->output->newLine(2);
                $this->output->writeln('contact with '. $duplicates->count() .' duplicates found ['. $contact->id .']');

                // Duplicates were found for this contact
                $duplicates->each(function (Contact $duplicateContact) use ($contact) {
                    $this->reallocateDuplicateRelations($contact, $duplicateContact);
                    $duplicateContact->delete();
                    $this->output->write('*');
                });

                $this->output->newLine();

                // Once handled, return false to indicate there might be other duplicates
                return false;
            }
        }

        $this->output->newLine();
        $this->output->writeln('no more duplicates found');
        return true;
    }

    protected function reallocateDuplicateRelations(Contact $contact, Contact $duplicateContact)
    {
        $type = $duplicateContact->type;
        if (
            $duplicateContact->rawType === 'externalContract' ||
            $duplicateContact->rawType === 'externalExecutive'
        ) {
            $type = ContactTypeEnum::external();
        }

        $duplicateContact->instruments()->each(function (Instrument $instrument) use ($contact, $type) {
            $instrument->contacts()->syncWithoutDetaching([ $contact->id => ['type', $type]]);
        });

        $duplicateContact->providers()->each(function (Provider $provider) use ($contact, $type) {
            $provider->contacts()->syncWithoutDetaching([ $contact->id => ['type', $type]]);
        });

        $duplicateContact->regions()->each(function (Region $region) use ($contact, $type) {
            $region->contacts()->syncWithoutDetaching([ $contact->id => ['type', $type]]);
        });
    }

    protected function reallocateTypeAttributeToPivot()
    {
        $this->output->writeln('reallocate own relations');
        $contacts = Contact::query()->whereNotNull('type')->get();

        $this->output->writeln($contacts->count() .' contacts with type found');

        foreach ($contacts as $contact) {
            // reallocate relations to move type attribute to the pivot
            $this->reallocateDuplicateRelations($contact, $contact);
            $contact->type = null;
            $contact->saveQuietly();
            $this->output->write('*');
        }
        $this->output->newLine();
    }
}
