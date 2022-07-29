<?php

namespace App\Models;

class Ward extends Model {
    protected $table = 'nora.paul.linen_ward';
    public $timestamps = false;
    protected static $orderByColumn = 'ward_name';

    protected $fillable = [
        'id',
        'office_name',	
        'alt_id'
    ];
}
