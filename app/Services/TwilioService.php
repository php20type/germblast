<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    public function sendSMS($to, $message)
    {
        // DEV MODE → Fake SMS (logs only)
        if (env('TWILIO_FAKE_MODE', true)) {
            \Log::info("FAKE SMS → To: {$to} | Message: {$message}");
            return true;
        }

        // REAL Twilio SMS
        $client = new Client(
            env('TWILIO_SID'),
            env('TWILIO_AUTH_TOKEN')
        );

        return $client->messages->create($to, [
            'from' => env('TWILIO_FROM'),
            'body' => $message,
        ]);
    }
}
