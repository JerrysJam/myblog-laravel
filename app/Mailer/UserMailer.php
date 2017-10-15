<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/15
 * Time: 上午9:26
 */

namespace App\Mailer;

use Illuminate\Support\Facades\Auth;

class UserMailer extends Mailer
{
    public function followNotifyEmail($email)
    {
        $data = [
            'url' => '127.0.0.1:8000',
            'name' => Auth::guard('api')->user()->name,
        ];

        $this->sendTo('zhihu_app_followed',$email,$data);
    }

    public function passwordReset($email, $token)
    {
        $data = [
            'url' => url('password/reset',$token),
            'name' => Auth::guard('api')->user()->name,
        ];
        $this->sendTo('zhihu_app_reset_password', $email, $data);
    }

    public function welcome(User $user)
    {
        $data = [
            'url' => route('email.verify',['token'=> $user ->confirmation_token]),
            'name' => $user->name
        ];

        $this->sendTo('zhihu_app_register', $user->email ,$data);
    }
}