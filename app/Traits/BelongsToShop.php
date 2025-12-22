<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToShop
{
    protected static function bootBelongsToShop()
    {
        // Don't apply if user is super admin
        if (Auth::check() && Auth::user()->role === 'super_admin') {
            return;
        }

        static::creating(function ($model) {
            if (Auth::check() && Auth::user()->shop_id) {
                $model->shop_id = Auth::user()->shop_id;
            }
        });

        static::addGlobalScope('shop', function (Builder $builder) {
            if (Auth::check() && Auth::user()->shop_id) {
                $builder->where('shop_id', Auth::user()->shop_id);
            } elseif (Auth::check() && Auth::user()->role !== 'super_admin') {
                // If not super admin and no shop assigned, shouldn't see anything
                $builder->whereRaw('1 = 0');
            }
        });
    }

    public function shop()
    {
        return $this->belongsTo(\App\Models\Shop::class);
    }
}
