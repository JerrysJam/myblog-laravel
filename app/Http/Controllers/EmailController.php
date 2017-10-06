<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function verify($token)
    {
        $user = User::where('confirmation_token',$token)->first();

        if (is_null($user)){
            falsh('邮箱验证失败!','danger');
            return redirect('/');
        }

        $user->is_active = 1 ;
        $user->confirmation_token =str_random(40);
        $user->save();
        Auth::login(); // 应该试试 Auth::login($user); 吧
        falsh('邮箱验证成功!','success');
        return redirect('/home');
    }
}
