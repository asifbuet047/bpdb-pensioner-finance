<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    /** @use HasFactory<\Database\Factories\DesignationFactory> */
    use HasFactory;

    protected $fillable = [
        'designation_code',
        'description_english',
        'description_bangla',
        'post_type',
        'order_number'
    ];

    public function officers()
    {
        return $this->hasMany(Officer::class);
    }
}
