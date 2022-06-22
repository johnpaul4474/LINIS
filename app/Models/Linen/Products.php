<?php

namespace App\Models\Linen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Products extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_products';
    public $timestamps = true;

    protected $casts = [
        'product_unit_cost' => 'float'
    ];

    protected $fillable = [
        'id',
        'raw_material_id',
        'material_used_quantity',	
        'raw_material_stock_number',	
        'stock_room_id',	
        'storage_room_id',
        'product_stock_id',	
        'product_bulk_id',
        'product_name',
        'create_date',
        'product_unit',
        'product_quantity',
        'product_unit_cost',	
        'created_at',	
        'updated_at',
        'deleted_at',
        'is_available',
        'is_condemned',
        'issued_office_id',
        'issued_ward_id'
    ];

    protected $dates = ['deleted_at'];
}
