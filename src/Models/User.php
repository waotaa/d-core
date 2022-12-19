<?php

namespace Vng\DennisCore\Models;

use Vng\DennisCore\Interfaces\DennisUserInterface;
use Vng\DennisCore\Traits\UserPropertiesTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

abstract class User extends Authenticatable implements MustVerifyEmail, DennisUserInterface
{
    use UserPropertiesTrait, HasFactory;
}
