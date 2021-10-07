<?php

namespace App;

namespace App\Traits;
use Illuminate\Support\Str;

trait Uuids
{

    /**
     * Boot function from laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} =  Str::uuid()->toString().Str::random(50).time().Str::random(50).Str::uuid()->toString();
        });
    }
}