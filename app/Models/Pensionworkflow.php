<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pensionworkflow extends Model
{
    /** @use HasFactory<\Database\Factories\PensionworkflowFactory> */
    use HasFactory;

    protected $fillable = [
        'pension_id',
        'officer_id',
        'status_from',
        'status_to',
        'message',
    ];

    protected $casts = [
        'pension_id' => 'integer',
        'officer_id' => 'integer',
    ];

    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }

    public function officer()
    {
        return $this->belongsTo(Officer::class);
    }
}
