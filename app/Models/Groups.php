<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Groups extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'groups'; // ตาราง users
    protected $primaryKey = 'groups_id';
    protected $fillable = [
        'groups_name',
        'groups_cost',
        'groups_cycle_month',
    ];
}
