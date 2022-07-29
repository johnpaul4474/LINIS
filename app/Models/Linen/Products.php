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

    protected $casts = [
        'product_unit_cost' => 'float'
    ];

    protected $fillable = [
        'raw_material_id',
        'raw_material_stock_number',
        'material_used_quantity',
        'stock_room_id',	
        'storage_room_id',
        'product_stock_id',	
        'product_bulk_id',
        'product_name',
        'create_date',
        'product_unit',
        'product_quantity',
        'product_issued_quantity',
        'product_available_quantity',
        'product_condemned_quantity',
        'product_losses_quantity',
        'product_returned_quantity',
        'product_unit_cost',
        'is_issued',
        'is_available',
        'is_condemned',
        'is_lossed',
        'is_returned',
        'issued_office_id',
        'issued_ward_id',
        'issued_date',
        'returned_date',
        'condemned_date',
        'lossed_date'
    ];

    protected $dates = ['deleted_at'];
}
