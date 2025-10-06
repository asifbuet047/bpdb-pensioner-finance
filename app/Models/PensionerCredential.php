<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PensionerCredential extends Model
{
    protected $fillable = ['password', 'pensioner_id'];

    public function pensioner()
    {
        return $this->belongsTo(Pensioner::class);
    }
}
