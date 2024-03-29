<?php

namespace Vng\DennisCore\Models;

class Role extends \Spatie\Permission\Models\Role
{
    const SUPER_ADMIN_ROLE = 'super-admin';
    const ROLES = [
        'super-admin' => 'Super Admin',
        'administrator' => 'Administrator',

        // global roles
        'instrument-manager' => 'Instrument beheerder',

        // organisation
        'user-manager-organisation' => 'Organisatie gebruikers beheerder',
        'instrument-manager-organisation' => 'Instrument beheerder organisatie'
    ];

    const ASSIGNABLE_ROLES = [
        'administrator' => [
            'administrator',
            'instrument-manager',
            'user-manager-organisation',
            'instrument-manager-organisation',
        ],
        'instrument-manager' => [],
        'user-manager-organisation' => [
            'instrument-manager-organisation',
            'user-manager-organisation',
        ],
        'instrument-manager-organisation' => [],
    ];

    public function getNameTranslatedAttribute(): string
    {
        return $this::ROLES[$this->name];
    }
    
    public function getAssignableRoles(): array
    {
        return self::ASSIGNABLE_ROLES[$this->name];
    }
}
