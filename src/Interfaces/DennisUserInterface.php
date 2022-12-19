<?php


namespace Vng\DennisCore\Interfaces;


interface DennisUserInterface
{
    public function getName(): ?string;
    public function getGivenName(): ?string;
    public function getSurName(): ?string;
    public function getEmail(): ?string;

    public function assignRandomPassword();
    public function sendAccountCreationNotification();
    public function sendPasswordResetNotification($token);
}
