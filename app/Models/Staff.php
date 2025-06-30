<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'maintenance_staff'; // ตาราง users
    protected $primaryKey = 'maintenance_id';
    protected $fillable = [
        'maintenance_name',
    ];
}
