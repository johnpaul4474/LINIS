<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersList extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_users';
    public $timestamps = true;

    

    protected $fillable = [
        'id',
        'username',	
        'name',	
        'employee_id',	
        'role_name',
        'role_id',	
        'ward_id',
        'office_id',
        'created_at',
        'updated_at',
        'deleted_at'
        
    ];

    protected $dates = ['deleted_at'];
}
