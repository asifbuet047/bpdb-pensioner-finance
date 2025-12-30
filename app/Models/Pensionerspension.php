<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensionerspension extends Model
{
    /** @use HasFactory<\Database\Factories\PensionerspensionFactory> */
    use HasFactory;

    protected $fillable = [
        'pensioner_id',
        'pension_id',
        'net_pension',
        'medical_allowance',
        'special_allowance',
        'festival_bonus',
        'bangla_new_year_bonus',
        'is_block',
        'message',
    ];

    protected $casts = [
        'pensioner_id' => 'integer',
        'pension_id' => 'integer',
        'net_pension' => 'integer',
        'medical_allowance' => 'integer',
        'special_allowance' => 'integer',
        'festival_bonus' => 'integer',
        'bangla_new_year_bonus' => 'integer',
        'is_block' => 'boolean',
    ];

    public function pensioner()
    {
        return $this->belongsTo(Pensioner::class);
    }
    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }
}
