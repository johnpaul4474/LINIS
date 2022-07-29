<?php

namespace App\Models\Linen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Requests extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_requests';
    public $timestamps = true;



    protected $fillable = [
        'id',
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
