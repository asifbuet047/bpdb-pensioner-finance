<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory;

    protected $fillable = [
        'office_code',
        'name_in_english',
        'name_in_bangla',
        'address',
        'mobile_no',
        'email',
        'is_payment_office',
        'payment_office_code'
    ];

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }

    public function pensioners()
    {
        return $this->hasMany(Pensioner::class);
    }
}
