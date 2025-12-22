<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use \App\Traits\BelongsToShop;

    protected $fillable = [
        'loan_id',
        'amount',
        'payment_date',
        'payment_type',
        'payment_method',
        'transaction_id',
        'receipt_number',
        'notes',
        'shop_id',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}
