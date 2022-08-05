<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Builder;

class ProductsList extends View {
    protected $table = 'nora.paul.linen_products_list';
    public $timestamps = false;

    protected static function boot() {
        parent::boot();
        
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy("is_available", "desc");
        });
    }
}
