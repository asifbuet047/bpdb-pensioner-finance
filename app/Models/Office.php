<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    /** @use HasFactory<\Database\Factories\OfficeFactory> */
    use HasFactory;

    protected $fillable = [
        'officeName',
        'officeNameInBangla',
        'officeCode'
    ];

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }
}
