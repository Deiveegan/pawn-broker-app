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
        'address',
        'city',
        'state',
        'pincode',
        'photo',
        'shop_id',
    ];

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
