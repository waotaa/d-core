<?php

namespace Vng\DennisCore\Traits;

use Illuminate\Support\Facades\Date;
use Vng\DennisCore\Notifications\AccountCreationEmail;
use Vng\DennisCore\Notifications\ResetPassword;
use Vng\DennisCore\Observers\UserObserver;
use Vng\DennisCore\Services\PasswordService;
use DateTime;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

trait UserPropertiesTrait
{
    use IsMember, IsManager, Notifiable;

    public string $generatedPassword;

    public static function bootUserPropertiesTrait()
    {
        static::observe(UserObserver::class);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getGivenName(): ?string
    {
        [$givenName] = $this->dissectName();
        return $givenName;
    }

    public function getSurName(): ?string
    {
        $names = $this->dissectName();
        return $names[1] ?? null;
    }

    public function dissectName()
    {
        $name = $this->getName();
        if (is_null($name)) {
            return null;
        }
        return explode(' ', $name, 2);
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function assignRandomPassword()
    {
        $password = PasswordService::generatePassword();
        $this->password = Hash::make($password);
        $this->generatedPassword = $password;

        $this->setPasswordUpdatedAtToNow();
    }

    /**
     * Send the account creation notification.
     */
    public function sendAccountCreationNotification(): void
    {
        $this->notify(new AccountCreationEmail());
    }

    /**
     * Send the password reset notification.
     */
    public function sendPasswordResetNotification($token): void
    {
        $this->notify(new ResetPassword($token));
    }

    public function isPasswordExpired(): bool
    {
        $sixMonthsAgo = (new DateTime())->modify('-6 months');
        return $this->password_updated_at < $sixMonthsAgo;
    }

    public function setPasswordUpdatedAtToNow()
    {
        $this->password_updated_at = Date::now();
    }

    public function canImpersonate()
    {
        return $this->isSuperAdmin();
    }

    public function canBeImpersonated()
    {
        return !$this->isSuperAdmin();
    }
}
