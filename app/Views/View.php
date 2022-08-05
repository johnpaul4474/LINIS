<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Model as BaseModel;

class View extends BaseModel {

    protected static function booted() {
        static::creating(function ($obj) {
            return false;
        });

        static::updating(function ($obj) {
            return false;
        });

        static::deleting(function ($obj) {
            return false;
        });
    }
}
