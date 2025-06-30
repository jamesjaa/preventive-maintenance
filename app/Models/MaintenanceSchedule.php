<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceSchedule extends Model
{
    public $timestamps = false;

    protected $table = 'maintenance_schedule';

    protected $primaryKey = 'pm_id';

    protected $fillable = [
        'hw_id',
        'planned_date',
        'cycle_month'
    ];

    // ความสัมพันธ์ตัวอย่าง (ถ้าอยากเชื่อมกับ Equipment)
    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'hw_id', 'hw_id');
    }
}
