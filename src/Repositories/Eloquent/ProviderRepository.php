<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Enums\ContactTypeEnum;
use Vng\DennisCore\Http\Requests\ProviderCreateRequest;
use Vng\DennisCore\Http\Requests\ProviderUpdateRequest;
use Vng\DennisCore\Models\Provider;
use Vng\DennisCore\Repositories\ProviderRepositoryInterface;

class ProviderRepository extends BaseRepository implements ProviderRepositoryInterface
{
    use OwnedEntityRepository, SoftDeletableRepository;

    public string $model = Provider::class;

    public function create(ProviderCreateRequest $request): Provider
    {
        return $this->saveFromRequest(new $this->model(), $request);
    }

    public function update(Provider $provider, ProviderUpdateRequest $request): Provider
    {
        return $this->saveFromRequest($provider, $request);
    }

    private function saveFromRequest(Provider $provider, FormRequest $request)
    {
        $organisationRepository = new OrganisationRepository();
        $organisation = $organisationRepository->find($request->input('organisation_id'));
        if (is_null($organisation)) {
            throw new \Exception('invalid organisation provided');
        }

        $provider = $provider->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'website' => $request->input('website'),
        ]);
//        $provider->owner()->associate($organisation->association);

        $provider->organisation()->associate($organisation);

        $provider->address()->disassociate();
        if ($request->has('address_id')) {
            $provider->address()->associate($request->input('address_id'));
        }

        $provider->save();

        return $provider;
    }

    public function attachContacts(Provider $provider, string|array $contactIds, ?string $type = null, ?string $label = null): Provider
    {
        if (!is_null($type) && !ContactTypeEnum::search($type)) {
            throw new \Exception('invalid type given ' . $type);
        }
        $pivotValues = [
            'type' => $type,
            'label' => $label
        ];
        $provider->contacts()->syncWithPivotValues((array) $contactIds, $pivotValues, false);
        return $provider;
    }

    public function detachContacts(Provider $provider, string|array $contactIds): Provider
    {
        $provider->contacts()->detach((array) $contactIds);
        return $provider;
    }
}
