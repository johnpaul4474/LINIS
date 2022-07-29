<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Ward extends Model {
    protected $table = 'nora.paul.linen_ward';
    public $timestamps = false;

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('ward_name');
        });
    }

    protected $fillable = [
        'id',
        'ward_name',	
        'alt_id'
    ];
}
