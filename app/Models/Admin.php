<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasRoles,SoftDeletes;

    protected $table = 'admins';
    protected $guard_name = 'admin';

    protected $fillable = ['first_name', 'last_name', 'email', 'phone', 'password','remember_token'];

    protected $hidden = ['password', 'remember_token'];

//    public function wallet()
//    {
//        return $this->hasOne(Wallet::class);
//    }
//    public function wallet()
//    {
//        return $this->hasOne(Wallet::class);
//    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'admin_id');
    }

}
