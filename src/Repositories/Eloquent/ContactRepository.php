<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Enums\ContactTypeEnum;
use Vng\DennisCore\Http\Requests\ContactCreateRequest;
use Vng\DennisCore\Http\Requests\ContactUpdateRequest;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Repositories\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    use OwnedEntityRepository;

    public string $model = Contact::class;

    public function create(ContactCreateRequest $request): Contact
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Contact $download, ContactUpdateRequest $request): Contact
    {
        return $this->saveFromRequest($download, $request);
    }

    public function saveFromRequest(Contact $contact, FormRequest $request): Contact
    {
        $organisationRepository = new OrganisationRepository();
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new \Exception('invalid organisation provided');
        }

        $contact->fill([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
        ]);
        $contact->organisation()->associate($organisation);

        $contact->save();
        return $contact;
    }

    public function attachInstruments(Contact $contact, array|string $instrumentIds, ?string $type = null, ?string $label = null): Contact
    {
        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new \Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type,
            'label' => $label
        ];
        $contact->instruments()->syncWithPivotValues((array) $instrumentIds, $pivotValues, false);
        return $contact;
    }

    public function detachInstruments(Contact $contact, array|string $instrumentIds): Contact
    {
        $contact->instruments()->detach((array) $instrumentIds);
        return $contact;
    }

    public function attachProviders(Contact $contact, array|string $providerIds, ?string $type = null, ?string $label = null): Contact
    {
        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new \Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type,
            'label' => $label
        ];
        $contact->providers()->syncWithPivotValues((array) $providerIds, $pivotValues, false);
        return $contact;
    }

    public function detachProviders(Contact $contact, array|string $providerIds): Contact
    {
        $contact->providers()->detach((array) $providerIds);
        return $contact;
    }

    public function attachRegionPages(Contact $contact, array|string $regionPageIds, ?string $type = null, ?string $label = null): Contact
    {
        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new \Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type,
            'label' => $label
        ];
        $contact->regionPages()->syncWithPivotValues((array) $regionPageIds, $pivotValues, false);
        return $contact;
    }

    public function detachRegionPages(Contact $contact, array|string $regionPageIds): Contact
    {
        $contact->regionPages()->detach((array) $regionPageIds);
        return $contact;
    }
}
