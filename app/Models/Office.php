<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory;

    protected $fillable = [
        'officeName',
        'officeNameInBangla',
        'officeCode',
        'address',
        'mobile_no',
        'email'
    ];

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    public function pensioners()
    {
        return $this->hasMany(Pensioner::class);
    }

    public function paymentOffices()
    {
        return $this->hasMany(PaymentOffice::class);
    }
}
