<?php

namespace App\Models;

class ActivityLogs extends Model {
    protected $table = 'nora.paul.linen_activity_logs';
   
    protected $fillable = [
        'employee_id',	
        'activity_logs'
    ];
}
