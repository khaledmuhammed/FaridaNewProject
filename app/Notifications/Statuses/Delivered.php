<?php

namespace App\Notifications\Statuses;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Message\Message;
use App\Notifications\Channels\SmsChannel;
use App\Models\{Order, OrderHistory};

class Delivered extends Notification
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
        return (new MailMessage)->markdown('mail.statuses.delivered', ['order' => $this->order])
                    ->subject('طلبك رقم #'.$this->order->id.' : '.$this->orderHistory->status->name_ar);
    }

    public function toSMS($notifiable)
    {
        return (new Message())->message("مرحباً ".$this->order->username."\n شكراً لطلبك من متجر ورود فريدة، ونتمنى أن تستمتع بمقتنياتك الجميلة.")
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
