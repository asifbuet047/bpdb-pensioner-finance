<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pension extends Model
{
    /** @use HasFactory<\Database\Factories\PensionFactory> */
    use HasFactory;

    protected $fillable = [
        'office_id',
        'month',
        'year',
        'sum_of_net_pension',
        'sum_of_medical_allowance',
        'sum_of_special_allowance',
        'sum_of_festival_bonus',
        'sum_of_bangla_new_year_bonus',
        'number_of_pensioners',
        'status'
    ];

    protected $casts = [
        'office_id' => 'integer',
        'month' => 'integer',
        'year' => 'integer',
        'sum_of_net_pension' => 'integer',
        'sum_of_medical_allowance' => 'integer',
        'sum_of_special_allowance' => 'integer',
        'sum_of_festival_bonus' => 'integer',
        'sum_of_bangla_new_year_bonus' => 'integer',
        'number_of_pensioners' => 'integer',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function workflows()
    {
        return $this->hasMany(Pensionworkflow::class);
    }

    public function pensionspensioner()
    {
        return $this->hasMany(Pensionerspension::class);
    }
}
