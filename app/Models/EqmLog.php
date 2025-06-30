<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EqmLog extends Model
{
    public $timestamps = false;
    protected $table = 'maintenance_log';
    protected $primaryKey = 'log_id';
    protected $fillable = [
        'pm_id',
        'hw_id',
        'maintenance_id',
        'created_at',
        'actual_date',
        'status',
        'detail',
        'cost',
    ];
}
