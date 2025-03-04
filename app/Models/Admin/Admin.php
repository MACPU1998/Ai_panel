<?php

namespace App\Models\Admin;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles;
    protected $table = 'admins';
    protected $guard_name = 'admin';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone'];

    protected $hidden = ['password', 'remember_token'];
}
