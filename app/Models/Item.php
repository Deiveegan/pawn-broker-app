<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'loan_id',
        'category',
        'item_name',
        'description',
        'weight',
        'purity',
        'estimated_value',
        'photo',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
