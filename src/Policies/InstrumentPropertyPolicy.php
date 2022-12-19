<?php

namespace Vng\DennisCore\Policies;

use Illuminate\Contracts\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Vng\DennisCore\Interfaces\IsManagerInterface;
use Vng\DennisCore\Models\Instrument;

abstract class InstrumentPropertyPolicy extends BasePolicy
{
    /**
     * @param IsManagerInterface&Authorizable $user
     * @param Model $model
     * @param Instrument $instrument
     * @return bool
     */
    public function attachInstrument(IsManagerInterface $user, Model $model, Instrument $instrument): bool
    {
        return $user->can('update', $instrument);
    }

    /**
     * @param IsManagerInterface&Authorizable $user
     * @param Model $model
     * @param Instrument $instrument
     * @return bool
     */
    public function detachInstrument(IsManagerInterface $user, Model $model, Instrument $instrument): bool
    {
        return $user->can('update', $instrument);
    }
}