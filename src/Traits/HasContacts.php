<?php


namespace Vng\DennisCore\Traits;

use Vng\DennisCore\Models\Contact;
use Vng\DennisCore\Models\Contactables;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait HasContacts
{
    public function contacts(): MorphToMany
    {
        return $this->morphToMany(Contact::class, 'contactable')
            ->using(Contactables::class)
            ->withPivot('type');
    }
}
