<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'zone'; // ตาราง users
    protected $primaryKey = 'zone_id';
    protected $fillable = [
        'zone_name',
    ];
}
