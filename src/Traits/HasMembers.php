<?php

namespace Vng\DennisCore\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Vng\DennisCore\Interfaces\IsMemberInterface;

trait HasMembers
{
    public abstract function members(): MorphToMany;

    public abstract function scopeIsMember(Builder $query, IsMemberInterface $user): Builder;

    public function hasMember(Model $user): bool
    {
        return $this->getAttribute('members') && $this->getAttribute('members')->contains($user->id);
    }

    public function join(Model $user): self
    {
        $this->members()->attach($user);
        return $this;
    }
}
