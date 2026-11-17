<?php

namespace App\Models;

use App\Domains\Identity\Models\User as DomainUser;

class User extends DomainUser
{
    // Alias for standard Laravel auth resolution
}
