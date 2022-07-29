<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class LinenRawMaterials extends Model {
    use SoftDeletes;

    protected static function boot() {
        parent::boot();
        
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy("stock_number", "desc");
        });
    }

    protected $table = 'nora.paul.linen_raw_materials';

    protected $casts = [
        'unit_cost' => 'float'
    ];

    protected $fillable = [
        'stock_number',	
        'quantity',	
        'unit',	
        'type',
        'description',	
        'unit_cost',
        'stock_room',
        'storage_room',	
        'is_archived',
        'is_available',
        'received_at'
    ];

    protected $dates = ['deleted_at'];
    protected $appends = ['total_price'];

    public function getTotalPriceAttribute() {
        return $this->attributes['quantity'] * $this->attributes['unit_cost'];
    }
}
