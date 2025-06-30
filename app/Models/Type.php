<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'type'; // ตาราง users
    protected $primaryKey = 'type_id';
    protected $fillable = [
        'type_name',
        'brand_id',
    ];
}
