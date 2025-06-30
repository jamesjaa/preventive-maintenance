<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Models extends Model
{
    public $timestamps = false; // ไม่มี created_at/updated_at

    protected $table = 'model'; // ตาราง users
    protected $primaryKey = 'model_id';
    protected $fillable = [
        'model_name',
        'type_id'
    ];
}
