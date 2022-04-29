<?php

namespace App\Models\Linen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LinenRawMaterials extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_raw_materials';
    public $timestamps = true;

    protected $casts = [
        'unit_cost' => 'float'
    ];

    protected $fillable = [
        'id',
        'stock_number',	
        'quantity',	
        'unit',	
        'description',	
        'unit_cost',
        'is_archived',
        'is_available',
        'stock_room',
        'storage_room',	
        'type',	
        'created_at',	
        'updated_at',
        'received_at'
    ];

    protected $dates = ['deleted_at'];
}
