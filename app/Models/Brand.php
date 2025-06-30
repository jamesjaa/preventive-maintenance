<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'brand'; // ตาราง users
    protected $primaryKey = 'brand_id';
    protected $fillable = [
        'brand_name',
        'groups_id'
    ];
}
