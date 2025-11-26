<?php

namespace App\Services;

use Twilio\Rest\Client;

class TwilioService
{
    // protected $client;
    // protected $from;

    // public function __construct()
    // {
    //     $sid = config('services.twilio.sid');
    //     $token = config('services.twilio.token');
    //     $this->from = config('services.twilio.from');

    //     $this->client = new Client($sid, $token);
    // }

    // /**
    //  * Send an SMS message.
    //  *
    //  * @param string $to
    //  * @param string $message
    //  * @return \Twilio\Rest\Api\V2010\Account\MessageInstance
    //  */
    // public function sendSms(string $to, string $message)
    // {
    //     return $this->client->messages->create($to, [
    //         'from' => $this->from,
    //         'body' => $message,
    //     ]);
    // }
}
