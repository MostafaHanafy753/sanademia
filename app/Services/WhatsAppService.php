<?php

namespace App\Services;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Api\V2010\Account\MessageInstance;
use Twilio\Rest\Client;

class WhatsAppService
{
    protected Client $client;
    protected string $from;

    /**
     * @throws ConfigurationException
     */
    public function __construct()
    {
        $sid    = config('services.twilio.sid');
        $token  = config('services.twilio.token');
        $this->from = config('services.twilio.whatsapp_from');

        $this->client = new Client($sid, $token);
    }

    /**
     * Send an OTP via WhatsApp.
     *
     * @param string $to The recipient's phone number (e.g., "+1234567890")
     * @param string $otp The one-time password to send
     * @return MessageInstance
     * @throws TwilioException
     */
    public function sendOtp(string $to, string $otp): MessageInstance|bool
    {
        return true;
        // Ensure the recipient's number is formatted for WhatsApp
        $recipient = "whatsapp:" . $to;

        return $this->client->messages->create($recipient, [
            'from' => $this->from,
            'body' => "Your OTP is: $otp",
        ]);
    }
}
