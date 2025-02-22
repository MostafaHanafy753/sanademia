<?php

namespace App\Services;

use App\Models\User;
use Random\RandomException;
use Twilio\Exceptions\TwilioException;

class SendOtp
{

    /**
     * @throws TwilioException
     * @throws RandomException
     */
    public function __construct(User $user)
    {
        $whatsappService= new WhatsAppService();
//        $user->otp = random_int(100000, 999999);
        $user->otp = 1234;
        $user->save();

        $whatsappService->sendOtp($user->phone_code.$user->phone_number,$user->otp);

        return $user->otp;
    }
}
