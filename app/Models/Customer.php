<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use \App\Traits\BelongsToShop;

    protected $fillable = [
        'name',
        'mobile',
        'email',
        'id_proof_type',
        'id_proof_number',
        'id_verified',
        'id_verified_at',
        'verification_response',
        'address',
        'city',
        'state',
        'pincode',
        'photo',
        'shop_id',
    ];

    protected $casts = [
        'id_verified' => 'boolean',
        'id_verified_at' => 'datetime',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
