<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentOfficesBank extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentOfficesBankFactory> */
    use HasFactory;


    protected $fillable = [
        'routing_number',
        'account_name',
        'account_number',
        'erp_bank_code',
        'office_id',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }
}
