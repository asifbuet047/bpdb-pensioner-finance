<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensioner extends Model
{
    /** @use HasFactory<\Database\Factories\PensionerFactory> */
    use HasFactory;

    protected $fillable = [
        'erp_id',
        'name',
        'name_bangla',
        'register_no',
        'last_basic_salary',
        'account_number',
        'office_id',
        'designation',
        'pension_payment_order',
        'father_name',
        'mother_name',
        'spouse_name',
        'birth_date',
        'joining_date',
        'prl_start_date',
        'prl_end_date',
        'is_self_pension',
        'phone_number',
        'email',
        'nid',
        'bank_routing_number',
        'status',
        'verified',
        'biometric_verified',
        'biometric_verification_type',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'joining_date' => 'date',
        'prl_start_date' => 'date',
        'prl_end_date' => 'date',
        'is_self_pension' => 'boolean',
        'verified' => 'boolean',
        'biometric_verified' => 'boolean',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function pensioner_credentail()
    {
        return $this->hasOne(PensionerCredential::class);
    }
}
