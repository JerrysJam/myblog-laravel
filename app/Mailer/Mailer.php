<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/15
 * Time: 上午9:16
 */

namespace App\Mailer;

use Illuminate\Support\Facades\Mail;
use Naux\Mail\SendCloudTemplate;

class Mailer
{
    public function sendTo($template, $email ,array $data)
    {
        $content = new SendCloudTemplate($template, $data);
        Mail::raw($content, function ($message) use ($email) {
            $message->from('17306959550@sina.cn', 'Zhihu');
            $message->to($email);
        });
    }
}