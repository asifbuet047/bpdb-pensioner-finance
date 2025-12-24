<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pensionerworkflow extends Model
{
    protected $fillable = [
        'pensioner_id',
        'officer_id',
        'status_from',
        'status_to'
    ];

    public function pensioner()
    {
        return $this->belongsTo(Pensioner::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}
