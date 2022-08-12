<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;

class ActivityLogs extends Model {
    protected $table = 'nora.paul.linen_activity_logs';
   
    protected $fillable = [
        'employee_id',	
        'activity_details'
    ];

    protected static function booted() {
        static::creating(function ($obj) {
            if(Auth::check()) {
                $obj->employee_id = Auth::user()->employee_id;
            }
        });
    }
}
