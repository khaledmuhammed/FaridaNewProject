<?php

namespace App\Notifications;

use App\Notifications\Channels\SmsChannel;
use App\Notifications\Message\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class MobileConfirm extends Notification
{
    use Queueable;
    private $code, $mobile;

    public function __construct($code, $mobile)
    {
        $this->code   = $code;
        $this->mobile = $mobile;
    }

    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    public function toSMS($notifiable)
    {
        return (new Message())->message("رمز التحقق هو " . $this->code)
                              ->numbers($this->mobile);
    }
}
