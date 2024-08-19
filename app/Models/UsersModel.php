<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersModel extends Model
{
    use HasFactory;

    protected $guard = 'admin';


    protected $fillable = [
        'username',
        'email',
        'userRole',
        'password',
    ];
}