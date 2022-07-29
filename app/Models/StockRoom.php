<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockRoom extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_stock_rooms';
    public $timestamps = true;

   
    protected $fillable = [
        'id',
        'stock_room',	
        'created_at',	
        'updated_at',
  
    ];

    protected $dates = ['deleted_at'];
}
