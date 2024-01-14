<?php
/**
 * Created by PhpStorm.
 * User: SHAREEF
 * Date: 3/21/2018
 * Time: 2:54 PM
 */

namespace App\Notifications\Channels;

use GuzzleHttp\Client;
use GuzzleHttp\TransferStats;
use Illuminate\Notifications\Notification;


class SmsChannel
{
    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        //Build the message instance
        $message = $notification->toSms($notifiable);

        return true;


        //Get the notification route
        if (!$to = $message->numbers) {
            if (!$to = $notifiable->routeNotificationForSms()) {
                logger()->error("Not Valid Mobile Number", ["User" => $notifiable]);
            }
        }

        if (config('app.env') != 'local') {

            $body = null;
            try {

                $client   = new Client();
                $response = $client->request('POST', config('services.sms.unifonic.url'), [
                    'json' => [
                        "AppSid"    => config('services.sms.unifonic.app_id'),
                        "Body"      => urldecode($message->message),
                        "Recipient" => $to,
                    ],
                ]);

                $body = json_decode($response->getBody()->getContents());

            } catch (\Exception $e) {
                logger()->error("SMS SENDING ERROR \n", ['to' => $to, "message", $e->getMessage()]);
            }

            if ($body) {
                try {
                    logger()->info("SMS : \n",
                        ['message' => $message->message,
                         'to'      => $to,
                         'Data'    => $body
                        ]);
                } catch (\Exception $e) {
                    logger()->error('SMS Logging error', ['to' => $to, "message", $e->getMessage()]);
                }
            }

        } else {

            logger()->info('FAKE SMS (' . round(strlen($message->message) / 70) . ")\n",
                ['message'   => $message->message,
                 'Recipient' => $to,]);
        }

    }
}
