<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOffice extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentOfficeFactory> */
    use HasFactory;

    protected $fillable = [
        'officeCode',
        'office_id'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
