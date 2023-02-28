<?php

// Organisation
$organisationGeneralPermissions = [
    // this permission allows seeing managers from the same organisation
    'manager.organisation.view',
];

// LocalParty
$localPartyGeneralPermissions = [
    ...$organisationGeneralPermissions,
    'localParty.viewAny',
    'localParty.view',
];

$localPartyAdministratorPermissions = [
    ...$localPartyGeneralPermissions,
    ...$organisationGeneralPermissions,
    'localParty.create',
    'localParty.update',
    'localParty.delete',
    'localParty.restore',
    'localParty.forceDelete',
];

// RegionalParty
$regionalPartyGeneralPermissions = [
    ...$organisationGeneralPermissions,
    'regionalParty.viewAny',
    'regionalParty.view',
];

$regionalPartyAdministratorPermissions = [
    ...$regionalPartyGeneralPermissions,
    ...$organisationGeneralPermissions,
    'regionalParty.create',
    'regionalParty.update',
    'regionalParty.delete',
    'regionalParty.restore',
    'regionalParty.forceDelete',
];

// NationalParty
$nationalPartyGeneralPermissions = [
    ...$organisationGeneralPermissions,
    'nationalParty.viewAny',
    'nationalParty.view',
];

$nationalPartyAdministratorPermissions = [
    ...$nationalPartyGeneralPermissions,
    ...$organisationGeneralPermissions,
    'nationalParty.create',
    'nationalParty.update',
    'nationalParty.delete',
    'nationalParty.restore',
    'nationalParty.forceDelete',
];

// Partnership
$partnershipGeneralPermissions = [
    ...$organisationGeneralPermissions,
    'partnership.viewAny',
    'partnership.view',
];

$partnershipAdministratorPermissions = [
    ...$partnershipGeneralPermissions,
    ...$organisationGeneralPermissions,
    'partnership.create',
    'partnership.update',
    'partnership.delete',
    'partnership.restore',
    'partnership.forceDelete',
];

// Region
$regionGeneralPermissions = [
    'region.viewAny',
    'region.view',
];

// Township
$townshipGeneralPermissions = [
    'township.viewAny',
    'township.view',
];

// General
$generalPermissions = [
    ...$organisationGeneralPermissions,
    ...$localPartyGeneralPermissions,
    ...$regionalPartyGeneralPermissions,
    ...$nationalPartyGeneralPermissions,
    ...$partnershipGeneralPermissions,
    ...$regionGeneralPermissions,
    ...$townshipGeneralPermissions,
];

// User
$userGeneralPermissions = [
    'role.viewAny',
    'role.view',

    'user.viewAny',
    'manager.viewAny',
];

$organisationUserPermissions = [
    ...$organisationGeneralPermissions,
    ...$userGeneralPermissions,

    // This permission allows you to create a manager for your organisation
    'manager.organisation.create',
    // This permission allows you to update a manager from your organisation
    'manager.organisation.update',
    // This permission allows you to delete a manager from your organisation
    'manager.organisation.delete',
    // This permission allows you to restore a manager from your organisation
    'manager.organisation.restore',
    // This permission allows you to forceDelete a manager from your organisation
    'manager.organisation.role.manage',
];

$userAdministratorPermissions = [
    ...$organisationUserPermissions,
    'user.view',
    'user.create',
    'user.update',
    'user.delete',
    'user.restore',
    'user.forceDelete',

    'manager.view',
    'manager.create',
    'manager.update',
    'manager.delete',
    'manager.restore',
    'manager.forceDelete',

    // This permission allows you to manage the role of a manager from your organisation
    'manager.role.manage',
    // This permission allows you to manage the organisation of a manager from your organisation
    'manager.organisation.manage',
];

// Address
$organisationAddressPermissions = [
    'address.viewAny',
    'address.organisation.view',
    'address.organisation.create',
    'address.organisation.update',
    'address.organisation.delete',
    'address.organisation.restore',
    'address.organisation.forceDelete',
];

$globalAddressPermissions = [
    ...$organisationAddressPermissions,
    'address.viewAll',
    'address.viewAny',
    'address.view',
    'address.create',
    'address.update',
    'address.delete',
    'address.restore',
    'address.forceDelete'
];

// Contact
$organisationContactPermissions = [
    'contact.viewAny',
    'contact.organisation.view',
    'contact.organisation.create',
    'contact.organisation.update',
    'contact.organisation.delete',
    'contact.organisation.restore',
    'contact.organisation.forceDelete',
];

$globalContactPermissions = [
    ...$organisationContactPermissions,
    'contact.viewAll',
    'contact.viewAny',
    'contact.view',
    'contact.create',
    'contact.update',
    'contact.delete',
    'contact.restore',
    'contact.forceDelete'
];

// Instruments
$instrumentPropertyPermissions = [
    'ageGroup.viewAny',
    'ageGroup.view',

    'employmentType.viewAny',
    'employmentType.view',

    'sector.viewAny',
    'sector.view',

    'instrumentType.viewAny',
    'instrumentType.view',

    'targetGroup.viewAny',
    'targetGroup.view',

    'targetGroupRegister.viewAny',
    'targetGroupRegister.view',

    'tile.viewAny',
    'tile.view',

    'neighbourhood.viewAny',
    'neighbourhood.view',
];
$instrumentPropertyManagementPermissions = [
    ...$instrumentPropertyPermissions,

    'neighbourhood.create',
    'neighbourhood.update',
    'neighbourhood.delete',
    'neighbourhood.restore',
    'neighbourhood.forceDelete',
];


$organisationInstrumentPermissions = [
    ...$instrumentPropertyPermissions,
    'instrument.viewAny',
    'instrument.organisation.view',
    'instrument.organisation.create',
    'instrument.organisation.update',
    'instrument.organisation.delete',
    'instrument.organisation.restore',
    'instrument.organisation.forceDelete',
];
$globalInstrumentPermissions = [
    ...$organisationInstrumentPermissions,
    ...$instrumentPropertyPermissions,
    'instrument.viewAll',
    'instrument.viewAny',
    'instrument.view',
    'instrument.create',
    'instrument.update',
    'instrument.delete',
    'instrument.restore',
    'instrument.forceDelete',
];

// Providers
$organisationProviderPermissions = [
    'provider.viewAny',
    'provider.organisation.view',
    'provider.organisation.create',
    'provider.organisation.update',
    'provider.organisation.delete',
    'provider.organisation.restore',
    'provider.organisation.forceDelete',
];
$globalProviderPermissions = [
    ...$organisationProviderPermissions,
    'provider.viewAll',
    'provider.viewAny',
    'provider.view',
    'provider.create',
    'provider.update',
    'provider.delete',
    'provider.restore',
    'provider.forceDelete'
];



return [
    // Models that need policy permissions (viewAny, view, create, update, delete, restore, forceDelete)
    'model-permissions' => [
        'address',
        'ageGroup',
        'contact',
        'download',
        'employmentType',
        'instrument',
        'instrument.organisation',
        'instrumentType',
        'link',
        'localParty',
        'location',
        'manager',
        'nationalParty',
        'organisation',
        'partnership',
        'provider',
        'provider.organisation',
        'rating',
        'region',
        'regionalParty',
        'registrationCode',
        'sector',
        'targetGroup',
        'targetGroupRegister',
        'tile',
        'township',
        'user',
        'video',
    ],
    // Roles and their associated permissions
    'matrix' => [
        'administrator' => [
            ...$generalPermissions,
            ...$localPartyAdministratorPermissions,
            ...$regionalPartyAdministratorPermissions,
            ...$nationalPartyAdministratorPermissions,
            ...$partnershipAdministratorPermissions,

            ...$globalAddressPermissions,
            ...$globalContactPermissions,
            ...$globalInstrumentPermissions,
            ...$globalProviderPermissions,

            ...$userAdministratorPermissions,
            ...$instrumentPropertyManagementPermissions,
        ],
        'instrument-manager' => [
            ...$generalPermissions,
            ...$globalAddressPermissions,
            ...$globalContactPermissions,
            ...$globalInstrumentPermissions,
            ...$globalProviderPermissions,
            ...$instrumentPropertyManagementPermissions,
        ],
        'instrument-manager-organisation' => [
            ...$generalPermissions,
            ...$organisationAddressPermissions,
            ...$organisationContactPermissions,
            ...$organisationInstrumentPermissions,
            ...$organisationProviderPermissions,
        ],
        'user-manager-organisation' => [
            ...$generalPermissions,
            ...$organisationUserPermissions,
        ],
    ],

    'super-admin-role' => 'super-admin',

    'roles' => [
        'super-admin' => 'Super Admin',
        'administrator' => 'Administrator',
        'instrument-manager' => 'Instrument beheerder',
        'instrument-manager-organisation' => 'Instrument beheerder voor organisatie',
        'user-manager-organisation' => 'Gebruikers beheerder voor organisatie'
    ],

    'assignable-roles' => [
        'administrator' => [
            'administrator',
            'instrument-manager',
            'environment-manager-national',
            'instrument-manager-organisation',
            'environment-content-manager',
            'environment-theme-manager',
            'user-manager-organisation'
        ],
        'instrument-manager' => [],
        'instrument-manager-organisation' => [],
        'user-manager-organisation' => [
            'instrument-manager-organisation',
            'user-manager-organisation',
        ],
    ]
];
