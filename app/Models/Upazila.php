<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upazila extends Model
{
    use HasFactory;

    protected $fillable = ['district_id', 'name'];

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function division()
    {
        return $this->hasOneThrough(
            Division::class,
            District::class,
            'id',          // Foreign key on districts
            'id',          // Foreign key on divisions
            'district_id', // Local key on upazilas
            'division_id'  // Local key on districts
        );
    }
}
