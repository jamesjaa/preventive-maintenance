<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'users'; // ตาราง users
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'fullname',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
