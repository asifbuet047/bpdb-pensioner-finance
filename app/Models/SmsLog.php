<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $fillable = [
        'clienttransid',
        'server_reference_code',
        'operatortransid',
        'type',
        'cli',
        'message',
        'msisdn',
        'status_code',
        'error_description',
        'delivery_status',
    ];

    protected $casts = [
        'msisdn' => 'array',
    ];

    public function logs()
    {
        return SmsLog::latest()->paginate(20);
    }
}
