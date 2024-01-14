<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\Message\Message;
use App\Notifications\Channels\SmsChannel;

class OrderNew extends Notification
{
    use Queueable;

    private $order;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class,'mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('mail.order.new',['order'=>$this->order])
            ->subject('تفاصيل الطلب رقم : #'.$this->order->id);    
    }

    public function toSMS($notifiable)
    {
        if ($this->order->email === null) {
            $token = hash('sha256', $this->order->id.$this->order->username);
            $url   = route('order',[$this->order->id,$token]);
            return (new Message())->message("تم إتمام الطلب بنجاح ، يمكنك الاطلاع على تفاصيل الطلب من خلال الرابط أدناه : ".$url)
                              ->numbers($this->order->mobile);
        } 
        return (new Message())->message("تم إتمام الطلب بنجاح، شكراً لطلبك من متجر ورود فريدة. ")
                              ->numbers($this->order->mobile);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
