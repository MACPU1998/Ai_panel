<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;

    protected $table = 'admins';
    protected $guard_name = 'admin';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'password'];

    protected $hidden = ['password', 'remember_token'];
}
