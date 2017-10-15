<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/14
 * Time: 下午10:40
 */

namespace App\Channels;

use App\Notifications\NewUserFollowNotification;
use Illuminate\Support\Facades\Notification;

class Sendcloudchannel
{
    public function send($notifiable, NewUserFollowNotification $notification)
    {
        $message = $notification->toSendcloud($notifiable);
    }
}