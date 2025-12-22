<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use \App\Traits\BelongsToShop;

    protected $fillable = [
        'customer_id',
        'loan_number',
        'loan_type',
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
        'valuation_amount',
        'total_weight',
        'market_rate',
        'status',
        'notes',
        'shop_id',
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

    /**
     * Calculate months passed for interest billing (rounded up, minimum 1)
     */
    public function getMonthsPassedAttribute()
    {
        if (!$this->loan_date) return 0;
        
        $totalDays = (int)$this->loan_date->diffInDays(now());
        
        if ($totalDays <= 0) return 1;
        
        // Billing Logic: 1-30 days = 1 month, 31-60 days = 2 months, etc.
        return (int)ceil($totalDays / 30);
    }

    /**
     * Calculate human-readable time passed
     * Logic: 
     * - If < 30 days: "1 Month 0 Days"
     * - If >= 30 days: "X Month(s) Y Day(s)"
     */
    public function getFormattedTimePassedAttribute()
    {
        if (!$this->loan_date) return '-';
        
        $totalDays = (int)$this->loan_date->diffInDays(now());
        
        if ($totalDays < 30) {
            return "1 Month 0 Days";
        }

        $months = floor($totalDays / 30);
        $days = $totalDays % 30;
        
        $msg = (int)$months . " Month(s)";
        if ($days > 0) {
            $msg .= " and " . (int)$days . " Day(s)";
        }
        
        return $msg;
    }

    /**
     * Maturity value is the total amount (Principal + Full Interest for the whole term)
     */
    public function getMaturityValueAttribute()
    {
        $months = (int)$this->loan_period_months;
        $interest = ($this->principal_amount * ($this->interest_rate / 100)) * $months;
        return $this->principal_amount + $interest;
    }

    /**
     * Calculate dynamic interest accrued based on actual time passed (Full month billing)
     */
    public function getInterestAccruedAttribute()
    {
        $months = (int)$this->months_passed;
        return ($this->principal_amount * ($this->interest_rate / 100)) * $months;
    }

    /**
     * Current dynamic outstanding balance: Principal + Interest Accrued - Payments
     */
    public function getRemainingBalanceAttribute()
    {
        $totalPayable = $this->principal_amount + $this->interest_accrued;
        $totalPaid = $this->payments()->sum('amount');
        return max(0, $totalPayable - $totalPaid);
    }

    public function getOutstandingPrincipalAttribute()
    {
        return $this->remaining_balance;
    }
}
