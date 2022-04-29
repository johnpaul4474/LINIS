<?php

namespace App\Models\Linen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $table = 'nora.paul.linen_storage';
    public $timestamps = true;

   
    protected $fillable = [
        'id',
        'stock_room_id',
        'storage_name',	
        'created_at',	
        'updated_at',
  
    ];

    protected $dates = ['deleted_at'];
}
