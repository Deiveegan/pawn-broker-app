<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'email',
        'id_proof_type',
        'id_proof_number',
        'address',
        'city',
        'state',
        'pincode',
        'photo',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
