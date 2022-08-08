<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Storage extends Model {
    use SoftDeletes;

    protected $table = 'nora.paul.linen_storage';
   
    protected $fillable = [
        'stock_room_id',
        'storage_name'
    ];

    protected $dates = ['deleted_at'];
    protected $with = ["rawMaterials"];

    public function rawMaterials() {
        return $this->hasMany(LinenRawMaterials::class, "storage_room");
    }
}
