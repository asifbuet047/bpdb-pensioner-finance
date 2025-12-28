<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    /** @use HasFactory<\Database\Factories\OfficerFactory> */
    use HasFactory;

    protected $fillable = [
        'erp_id',
        'name',
        'designation_id',
        'role_id',
        'office_id',
        'password',
    ];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function pensionerworkflows()
    {
        return $this->hasMany(Pensionerworkflow::class);
    }

    public function pensionworkflows()
    {
        return $this->hasMany(Pensionworkflow::class);
    }
}
