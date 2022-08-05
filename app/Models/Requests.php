<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model {
    use SoftDeletes;

    protected $table = 'nora.paul.linen_requests';

    protected $fillable = [
        'product_name_request',
        'product_quantity_request',
        'name',
        'employee_id',
        'role_name',
        'role_id',
        'ward_id',
        'office_id',
        'status',
        'processed_by',
        'processed_by_emp_id',
        'processed_at',
        'comments'
    ];

    protected $dates = ['deleted_at'];
}
