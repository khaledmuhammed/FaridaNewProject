<?php

namespace App\Notifications\Statuses;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Message\Message;
use App\Notifications\Channels\SmsChannel;
use App\Models\{Order, OrderHistory};

class Validating extends Notification
{
    use Queueable;

    private $order, $orderHistory;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order, OrderHistory $orderHistory)
    {
        $this->order = $order;
        $this->orderHistory = $orderHistory;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class,'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $token = hash('sha256', $this->order->id.$this->order->username);
        $url   = route('bankTransfer.show',[$this->order->id,$token]);
        return (new MailMessage)->markdown('mail.statuses.validating', ['order' => $this->order, 'url' => $url])
                    ->subject('طلبك رقم #'.$this->order->id.' : '.$this->orderHistory->status->name_ar);
    }

    public function toSMS($notifiable)
    {
        $token = hash('sha256', $this->order->id.$this->order->username);
        $url   = route('bankTransfer.show',[$this->order->id,$token]);
        return (new Message())->message("نرجو التكرم بتحويل مبلغ الطلب على حساباتنا البنكية : \nمصرف الإنماء \n68201698498000 \n آيبان \SA2405000068201698498000 \nمصرف الراجحي \n454000010006086033087 \n آيبان \SA5880000454608016033087 \nمؤسسة ورود فريدة\n ثم تعبئة نموذج التحويل من خلال الرابط أدناه : \n".$url)
                              ->numbers($this->order->mobile);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
