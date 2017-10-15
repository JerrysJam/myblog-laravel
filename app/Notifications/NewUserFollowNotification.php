<?php

namespace App\Notifications;

use App\Channels\Sendcloudchannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class NewUserFollowNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
//        return ['mail'];
        return ['database',Sendcloudchannel::class];
    }

    public function toSendcloud($notifiable)
    {
        $data = [
            'url' => '127.0.0.1:8000',
            'name' => Auth::guard('api')->user()->name,
        ];

        $template = new SendCloudTemplate('zhihu_app_followed', $data);
        Mail::raw($template, function ($message) use ($notifiable) {
            $message->from('17306959550@sina.cn', 'Zhihu');
            $message->to($notifiable->email)->cc('17306959550@sina.cn');
        });

    }
    
    public function toDatabase($notifiable)
    {
        return [
            'name' => Auth::guard('api')->user()->name,
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
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
