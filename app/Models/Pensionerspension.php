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
        'is_block'
    ];

    protected $casts = [
        'pensioner_id' => 'integer',
        'pension_id' => 'integer',
        'is_block' => 'boolean'
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
