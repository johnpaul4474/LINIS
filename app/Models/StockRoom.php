<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class StockRoom extends Model {
    use SoftDeletes;

    protected $table = 'nora.paul.linen_stock_rooms';

    protected $fillable = [
        'stock_room'
    ];

    protected $dates = ['deleted_at'];
}
