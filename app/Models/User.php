<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $connection = 'sqlsrv';
    protected $table = 'users'; // ตาราง users
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'fullname',
        'password',
        'created_date',
    ];
    const CREATED_AT = 'created_date';
    const UPDATED_AT = null;

    protected $hidden = [
        'password',
    ];
}
