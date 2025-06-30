<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public $timestamps = false;
    protected $table = 'equipment';
    protected $primaryKey = 'hw_id';
    protected $fillable = [
        'hw_name',
        'hw_sn',
        'groups_id',
        'type_id',
        'brand_id',
        'model_id',
        'zone_id',
        'hw_created_date',
        'created_at'
    ];
}
