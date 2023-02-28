<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Address;
use Vng\DennisCore\Models\AgeGroup;
use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\EmploymentType;
use Vng\DennisCore\Models\Instrument;
use Vng\DennisCore\Models\Location;
use Vng\DennisCore\Models\Neighbourhood;
use Vng\DennisCore\Models\Region;
use Vng\DennisCore\Models\Sector;
use Vng\DennisCore\Models\TargetGroup;
use Vng\DennisCore\Models\TargetGroupRegister;
use Vng\DennisCore\Models\Tile;
use Vng\DennisCore\Models\Township;

class InstrumentPolicy extends BasePolicy
{
    use HandlesAuthorization;

    public function viewAny(IsManagerInterface $user): bool
    {
        return $user->managerCan('instrument.viewAny');
    }

    public function viewAll(IsManagerInterface $user): bool
    {
        return $user->managerCan('instrument.viewAll');
    }

    public function view(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $user->managerCan('instrument.viewAny');

//        if (!$instrument->hasOwner()
//            && $user->can('view national instrument')
//        ) {
//            return true;
//        }
//        if ($instrument->hasOwner()
//            && $user->can('instrument.organisation.view')
//            && $instrument->isUserMemberOfOwner($user)
//        ) {
//            return true;
//        }
//        return $user->can('instrument.view');
    }

    public function create(IsManagerInterface $user): bool
    {
        return $user->managerCan('instrument.organisation.create')
            || $user->managerCan('instrument.create');
    }

    /**
     * @param IsManagerInterface&DennisUserInterface $user
     * @param Instrument $instrument
     * @return bool
     */
    public function update(IsManagerInterface $user, Instrument $instrument): bool
    {
        if ($instrument->hasOwner()
            && $user->managerCan('instrument.organisation.update')
            && $instrument->isUserMemberOfOwner($user)
        ) {
            return true;
        }
        return $user->managerCan('instrument.update');
    }

    /**
     * @param IsManagerInterface&DennisUserInterface $user
     * @param Instrument $instrument
     * @return bool
     */
    public function delete(IsManagerInterface $user, Instrument $instrument): bool
    {
        if ($instrument->hasOwner()
            && $user->managerCan('instrument.organisation.delete')
            && $instrument->isUserMemberOfOwner($user)
        ) {
            return true;
        }
        return $user->managerCan('instrument.delete');
    }

    /**
     * @param IsManagerInterface&DennisUserInterface $user
     * @param Instrument $instrument
     * @return bool
     */
    public function restore(IsManagerInterface $user, Instrument $instrument): bool
    {
        if ($instrument->hasOwner()
            && $user->managerCan('instrument.organisation.restore')
            && $instrument->isUserMemberOfOwner($user)
        ) {
            return true;
        }
        return $user->managerCan('instrument.restore');
    }

    /**
     * @param IsManagerInterface&DennisUserInterface $user
     * @param Instrument $instrument
     * @return bool
     */
    public function forceDelete(IsManagerInterface $user, Instrument $instrument): bool
    {
        if ($instrument->hasOwner()
            && $user->managerCan('instrument.organisation.forceDelete')
            && $instrument->isUserMemberOfOwner($user)
        ) {
            return true;
        }
        return $user->managerCan('instrument.forceDelete');
    }

//    All things you can do when you can edit
    public function attachAnyLocation(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachLocation(IsManagerInterface $user, Instrument $instrument, Location $location): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachLocation(IsManagerInterface $user, Instrument $instrument, Location $location): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyAddress(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachAddress(IsManagerInterface $user, Instrument $instrument, Address $address): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachAddress(IsManagerInterface $user, Instrument $instrument, Address $address): bool
    {
        return $this->update($user, $instrument);
    }

    public function addRegistrationCode(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function addLink(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function addDownload(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function addVideo(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyContact(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachContact(IsManagerInterface $user, Instrument $instrument, Contact $contact): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachContact(IsManagerInterface $user, Instrument $instrument, Contact $contact): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyAgeGroup(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachAgeGroup(IsManagerInterface $user, Instrument $instrument, AgeGroup $ageGroup): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachAgeGroup(IsManagerInterface $user, Instrument $instrument, AgeGroup $ageGroup): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyEmploymentType(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachEmploymentType(IsManagerInterface $user, Instrument $instrument, EmploymentType $employmentType): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachEmploymentType(IsManagerInterface $user, Instrument $instrument, EmploymentType $employmentType): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnySector(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachSector(IsManagerInterface $user, Instrument $instrument, Sector $sector): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachSector(IsManagerInterface $user, Instrument $instrument, Sector $sector): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyTargetGroupRegister(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachTargetGroupRegister(IsManagerInterface $user, Instrument $instrument, TargetGroupRegister $targetGroupRegister): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachTargetGroupRegister(IsManagerInterface $user, Instrument $instrument, TargetGroupRegister $targetGroupRegister): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyTargetGroup(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachTargetGroup(IsManagerInterface $user, Instrument $instrument, TargetGroup $targetGroup): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachTargetGroup(IsManagerInterface $user, Instrument $instrument, TargetGroup $targetGroup): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyTile(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachTile(IsManagerInterface $user, Instrument $instrument, Tile $tile): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachTile(IsManagerInterface $user, Instrument $instrument, Tile $tile): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyAvailableRegion(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachAvailableRegion(IsManagerInterface $user, Instrument $instrument, Region $region): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachAvailableRegion(IsManagerInterface $user, Instrument $instrument, Region $region): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyAvailableTownship(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachAvailableTownship(IsManagerInterface $user, Instrument $instrument, Township $township): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachAvailableTownship(IsManagerInterface $user, Instrument $instrument, Township $township): bool
    {
        return $this->update($user, $instrument);
    }

    public function attachAnyAvailableNeighbourhood(IsManagerInterface $user, Instrument $instrument): bool
    {
        return $this->update($user, $instrument);
    }
    public function attachAvailableNeighbourhood(IsManagerInterface $user, Instrument $instrument, Neighbourhood $neighbourhood): bool
    {
        return $this->update($user, $instrument);
    }
    public function detachAvailableNeighbourhood(IsManagerInterface $user, Instrument $instrument, Neighbourhood $neighbourhood): bool
    {
        return $this->update($user, $instrument);
    }
}
