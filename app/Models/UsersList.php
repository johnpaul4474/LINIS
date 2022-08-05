<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class UsersList extends Model {
    use SoftDeletes;

    protected $table = 'nora.paul.linen_users';

    protected $fillable = [
        'username',	
        'name',	
        'employee_id',	
        'role_name',
        'role_id',	
        'ward_id',
        'office_id',
        'password'
    ];

    protected $dates = ['deleted_at'];
}
