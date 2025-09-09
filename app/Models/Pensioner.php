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
        'register_no',
        'basic_salary',
        'medical_allowance',
        'incentive_bonus',
        'bank_name',
        'account_number'
    ];
}
