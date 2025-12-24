<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $appends = [
        'medical_allowance',
        'bank_name',
        'branch_name',
        'office_name'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function pensioner_credentail()
    {
        return $this->hasOne(PensionerCredential::class);
    }

    public function workflows()
    {
        return $this->hasMany(Pensionerworkflow::class);
    }

    public function getMedicalAllowanceAttribute()
    {
        if (Carbon::parse($this->birth_date)->age >= 65) {
            return 2500;
        } else {
            return 1500;
        }
    }

    public function getBankNameAttribute()
    {
        if ($this->bank_routing_number) {
            return Bank::where('routing_number', $this->bank_routing_number)->get()->value('bank_name') ?? '';
        }
    }

    public function getBranchNameAttribute()
    {
        if ($this->bank_routing_number) {
            return Bank::where('routing_number', $this->bank_routing_number)->get()->value('branch_name') ?? '';
        }
    }

    public function getOfficeNameAttribute()
    {
        if ($this->office_id) {
            return Office::where('id', $this->office_id)->get()->value('name_in_english') ?? '';
        }
    }
}
