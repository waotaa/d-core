<?php

namespace Vng\DennisCore\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Http\FormRequest;
use Vng\DennisCore\Http\Requests\OrganisationCreateRequest;
use Vng\DennisCore\Http\Requests\OrganisationUpdateRequest;
use Vng\DennisCore\Interfaces\OrganisationEntityInterface;
use Vng\DennisCore\Models\Manager;
use Vng\DennisCore\Models\Organisation;
use Vng\DennisCore\Repositories\OrganisationRepositoryInterface;

class OrganisationRepository extends BaseRepository implements OrganisationRepositoryInterface
{
    public string $model = Organisation::class;

    public function addManagerIsMemberCondition(Builder $query, Manager $manager): Builder
    {
        return $query->whereHas('managers', function (Builder $query) use ($manager) {
            $query->where('managers.id', $manager->id);
        });
    }

    public function new(): Organisation
    {
        return new $this->model();
    }

    public function create(OrganisationCreateRequest $request): Organisation
    {
        return $this->saveFromRequest($this->new(), $request);
    }

    public function update(Organisation $organisation, OrganisationUpdateRequest $request): Organisation
    {
        return $this->saveFromRequest($organisation, $request);
    }

    public function saveFromRequest(Organisation $organisation, FormRequest $request): Organisation
    {
        $organisation = $organisation->fill([]);
        $organisation->save();
        return $organisation;
    }

    /**
     * Associates the organisation entity to the organisation to create a double reference for easy lookup
     */
    public function associateOrganisationable(Model $organisationEntity): ?Organisation
    {
        if (!$organisationEntity instanceof OrganisationEntityInterface) {
            throw new \Exception('Model must implement OrganisationEntityInterface');
        }
        /** @var Organisation $organisation */
        $organisation = $organisationEntity->organisation;
        if (is_null($organisation)) {
            throw new \Exception('Model must belong to an organisation');
        }
        $organisation->organisationable()->associate($organisationEntity);
        return $organisation;
    }


    public function attachManagers(Organisation $organisation, string|array $managerIds): Organisation
    {
        $organisation->managers()->syncWithoutDetaching($managerIds);
        return $organisation;
    }

    public function detachManagers(Organisation $organisation, string|array $managerIds): Organisation
    {
        $organisation->managers()->detach($managerIds);
        return $organisation;
    }

    public function attachContacts(Organisation $organisation, string|array $contactIds): Organisation
    {
        $organisation->contacts()->syncWithoutDetaching((array) $contactIds);
        return $organisation;
    }

    public function detachContacts(Organisation $organisation, string|array $contactIds): Organisation
    {
        $organisation->contacts()->detach((array) $contactIds);
        return $organisation;
    }
}
