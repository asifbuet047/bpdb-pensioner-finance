<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\SmsLog;

class GpCmpSmsService
{
    protected string $url;
    protected string $username;
    protected string $password;
    protected string $billMsisdn;
    protected string $rnCode;
    protected string $cli;

    public function __construct()
    {
        $this->url = config('services.gp_cmp.url');
        $this->username = config('services.gp_cmp.username');
        $this->password = config('services.gp_cmp.password');
        $this->billMsisdn = config('services.gp_cmp.bill_msisdn');
        $this->rnCode = config('services.gp_cmp.rn_code');
        $this->cli = config('services.gp_cmp.cli');
    }

    protected function generateTransactionId(): string
    {
        return substr(Str::uuid()->getHex(), 0, 25);
    }

    public function sendSingle(string $msisdn, string $message, string $messageType = '1')
    {
        $clientTransId = $this->generateTransactionId();

        $log = SmsLog::create([
            'clienttransid' => $clientTransId,
            'type' => 'single',
            'cli' => $this->cli,
            'message' => $message,
            'msisdn' => [$msisdn],
            'delivery_status' => 'pending',
        ]);

        $payload = [
            'username' => $this->username,
            'password' => $this->password,
            'apicode' => '1',
            'msisdn' => [$msisdn],
            'countrycode' => '880',
            'cli' => $this->cli,
            'messagetype' => $messageType,
            'message' => $message,
            'clienttransid' => $clientTransId,
            'bill_msisdn' => $this->billMsisdn,
            'tran_type' => 'P',
            'request_type' => 'S',
            'rn_code' => $this->rnCode,
        ];

        $response = Http::timeout(30)->post($this->url, $payload);
        $data = $response->json();

        $log->update([
            'status_code' => $data['statusInfo']['statusCode'] ?? null,
            'error_description' => $data['statusInfo']['errordescription'] ?? null,
            'server_reference_code' => $data['statusInfo']['serverReferenceCode'] ?? null,
        ]);

        return $data;
    }

    public function sendBulk(array $msisdns, string $message, string $messageType = '1')
    {
        $clientTransId = $this->generateTransactionId();

        $log = SmsLog::create([
            'clienttransid' => $clientTransId,
            'type' => 'bulk',
            'cli' => $this->cli,
            'message' => $message,
            'msisdn' => $msisdns,
            'delivery_status' => 'pending',
        ]);

        $payload = [
            'username' => $this->username,
            'password' => $this->password,
            'apicode' => '5',
            'msisdn' => $msisdns,
            'countrycode' => '880',
            'cli' => $this->cli,
            'messagetype' => $messageType,
            'message' => $message,
            'clienttransid' => $clientTransId,
            'bill_msisdn' => $this->billMsisdn,
            'tran_type' => 'P',
            'request_type' => 'B',
            'rn_code' => $this->rnCode,
        ];

        $response = Http::timeout(60)->post($this->url, $payload);
        $data = $response->json();

        $log->update([
            'status_code' => $data['statusInfo']['statusCode'] ?? null,
            'error_description' => $data['statusInfo']['errordescription'] ?? null,
            'server_reference_code' => $data['statusInfo']['serverReferenceCode'] ?? null,
        ]);

        return $data;
    }

    public function checkDelivery(array $msisdns, string $operatorTransId, string $messageType = '1')
    {
        $clientTransId = $this->generateTransactionId();

        $payload = [
            'username' => $this->username,
            'password' => $this->password,
            'apicode' => '4',
            'msisdn' => $msisdns,
            'countrycode' => '880',
            'cli' => $this->cli,
            'messagetype' => $messageType,
            'clienttransid' => $clientTransId,
            'operatortransid' => $operatorTransId,
        ];

        $response = Http::post($this->url, $payload);
        $data = $response->json();

        if (!empty($data['statusInfo']['deliverystatus'])) {
            foreach ($data['statusInfo']['deliverystatus'] as $status) {
                [$number, $state] = explode('-', $status);

                SmsLog::whereJsonContains('msisdn', $number)
                    ->update([
                        'delivery_status' => strtolower($state) === 'delivered' ? 'delivered' : 'undelivered',
                    ]);
            }
        }

        return $data;
    }

    public function checkBalance()
    {
        $payload = [
            'username' => $this->username,
            'password' => $this->password,
            'apicode' => '3',
            'clienttransid' => $this->generateTransactionId(),
        ];

        return Http::post($this->url, $payload)->json();
    }
}
