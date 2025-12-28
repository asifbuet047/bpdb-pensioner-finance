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
        'number_of_pensioners',
        'total_amount',
    ];

    protected $casts = [
        'month' => 'integer',
        'year' => 'integer',
        'number_of_pensioners' => 'integer',
        'total_amount' => 'integer',
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
