<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Bank;
use App\Models\Office;
use App\Models\PensionerCredential;
use App\Models\Pensionerworkflow;
use App\Models\Pensionerspension;


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
        'religion',
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
        'office_name',
        'net_pension',
        'special_benifit',
        'bonus'
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function pensionerCredential()
    {
        return $this->hasOne(PensionerCredential::class);
    }

    public function workflows()
    {
        return $this->hasMany(Pensionerworkflow::class);
    }
    public function pensionerspensions()
    {
        return $this->hasMany(Pensionerspension::class);
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
            return Bank::where('routing_number', $this->bank_routing_number)->value('branch_name') ?? '';
        }
    }

    public function getOfficeNameAttribute()
    {
        if ($this->office_id) {
            return Office::where('id', $this->office_id)->value('name_in_english') ?? '';
        }
    }

    protected function getPensionPercentage(int $years): float
    {
        if ($years >= 25) return 0.90;
        if ($years >= 24) return 0.87;
        if ($years >= 23) return 0.83;
        if ($years >= 22) return 0.79;
        if ($years >= 21) return 0.75;
        if ($years >= 20) return 0.72;
        if ($years >= 19) return 0.69;
        if ($years >= 18) return 0.65;
        if ($years >= 17) return 0.63;
        if ($years >= 16) return 0.57;
        if ($years >= 15) return 0.54;
        if ($years >= 14) return 0.51;
        if ($years >= 13) return 0.47;
        if ($years >= 12) return 0.43;
        if ($years >= 11) return 0.39;
        if ($years >= 10) return 0.36;
        if ($years >= 9)  return 0.33;
        if ($years >= 8)  return 0.30;
        if ($years >= 7)  return 0.27;
        if ($years >= 6)  return 0.24;
        if ($years >= 5)  return 0.21;
        return 0.00;
    }

    public function getNetPensionAttribute()
    {
        if (!$this->joining_date || !$this->prl_end_date) {
            return 0;
        }

        $joiningDate = Carbon::parse($this->joining_date);
        $prlEndDate  = Carbon::parse($this->prl_end_date);

        $jobLifeInYears = $joiningDate->diffInYears($prlEndDate);

        $percentage = $this->getPensionPercentage($jobLifeInYears);

        return round(($percentage * $this->last_basic_salary / 2.0), 0);
    }


    public function getSpecialBenifitAttribute()
    {
        if ($this->net_pension < 17389) {
            return round(max($this->net_pension * 0.15, 750), 0);
        }
        return round($this->net_pension * 0.10, 0);
    }

    public function getBonusAttribute()
    {
        if ($this->religion === 'Islam') {
            if (Carbon::now()->month()) {
                # code...
            } else {
                # code...
            }
            
            return $this->net_pension;
        } else {
            return $this->net_pension * 2.0;
        }
    }
}
