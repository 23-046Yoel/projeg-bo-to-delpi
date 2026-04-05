<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WhatsAppService
{
    protected $userCode;
    protected $secret;
    protected $deviceId;
    protected $masterNumber;

    public function __construct()
    {
        $this->userCode     = config('services.kirimi.user_code');
        $this->secret       = config('services.kirimi.secret');
        $this->deviceId     = config('services.kirimi.device_id');
        $this->masterNumber = config('services.kirimi.master_number');
    }

    public function getMasterNumber()
    {
        return $this->masterNumber;
    }

    public function sendMessage($phone, $message)
    {
        \Log::info("WA to $phone: $message");

        if (!$this->userCode || !$this->secret) {
            \Log::warning("Kirimi credentials not configured, skipping send.");
            return;
        }

        try {
            $response = Http::timeout(15)
                ->post('https://api.kirimi.id/v1/send-message', [
                    'user_code' => $this->userCode,
                    'secret'    => $this->secret,
                    'device_id' => $this->deviceId,
                    'receiver'  => $phone,
                    'message'   => $message,
                ]);

            if ($response->failed()) {
                \Log::error("Kirimi Send Failure: " . $response->status() . " - " . $response->body());
            } else {
                \Log::info("Kirimi Send Success: " . $response->body());
            }

            return $response;
        } catch (\Exception $e) {
            \Log::error("Kirimi Connection Exception: " . $e->getMessage());
            return null;
        }
    }

    public function sendButton($phone, $message, $buttons)
    {
        \Log::info("WA Button to $phone: $message", ['buttons' => $buttons]);
    }
}
