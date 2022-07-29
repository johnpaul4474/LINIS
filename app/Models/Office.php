<?php

namespace App\Models;

class Office extends Model {
    protected $table = 'nora.paul.linen_office';
    public $timestamps = false;
    protected static $orderByColumn = 'office_name';

    protected $fillable = [
        'id',
        'office_name',	
        'alt_id'
    ];
}
