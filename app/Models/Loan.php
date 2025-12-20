<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $fillable = [
        'customer_id',
        'loan_number',
        'principal_amount',
        'interest_rate',
        'interest_type',
        'duration_days',
        'loan_period_months',
        'loan_date',
        'due_date',
        'grace_period_days',
        'penalty_rate',
        'total_amount',
        'status',
        'notes',
    ];

    protected $casts = [
        'loan_date' => 'date',
        'due_date' => 'date',
        'principal_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function getTicketNumberAttribute()
    {
        return $this->loan_number;
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getOutstandingPrincipalAttribute()
    {
        return $this->remaining_balance;
    }

    public function getRemainingBalanceAttribute()
    {
        $totalPaid = $this->payments()->sum('amount');
        return $this->total_amount - $totalPaid;
    }
}
