<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use \App\Traits\BelongsToShop;

    protected $fillable = [
        'loan_id',
        'category',
        'item_name',
        'description',
        'weight',
        'purity',
        'estimated_value',
        'photo',
        'shop_id',
    ];

    public function getFormattedWeightAttribute()
    {
        if (!$this->weight) return '-';
        
        $totalWeight = (float)$this->weight;
        $sovereign = floor($totalWeight / 8);
        $remainingGrams = $totalWeight - ($sovereign * 8);
        $grams = floor($remainingGrams);
        $milli = round(($remainingGrams - $grams) * 1000);

        $parts = [];
        if ($sovereign > 0) $parts[] = $sovereign . ' sovereign';
        if ($grams > 0) $parts[] = $grams . ' gram';
        if ($milli > 0) $parts[] = $milli . ' mg';

        return count($parts) > 0 ? implode(' and ', $parts) : $totalWeight . ' gms';
    }

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
