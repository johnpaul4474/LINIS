<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLogs extends Model
{
    use HasFactory;
    protected $table = 'nora.paul.linen_activity_logs';
    public $timestamps = true;

   
    protected $fillable = [
        'id',
        'employee_id',	
        'activity_logs',
        'created_at',	
        'updated_at',
  
    ];
}
