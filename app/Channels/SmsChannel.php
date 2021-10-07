<?php /** * Created by PhpStorm. * User: Al * Date: 18/3/2020 * Time: 09:28 م
 */

namespace App\Channels;

use Illuminate\Notifications\Notification;

class SmsChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);
    }
}