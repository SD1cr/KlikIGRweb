<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class UserAdmin extends Model implements AuthenticatableContract, CanResetPasswordContract{

    use Authenticatable, CanResetPassword;

    protected $table = 'users_admin';

    protected $hidden = ['password', 'remember_token'];
}


