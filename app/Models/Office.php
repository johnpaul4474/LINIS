<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Office extends Model {
    protected $table = 'nora.paul.linen_office';
    public $timestamps = false;

    protected static function boot() {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('office_name');
        });
    }

    protected $fillable = [
        'id',
        'office_name',	
        'alt_id'
    ];
}
