<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/14
 * Time: 下午5:04
 */

namespace App\Repositories;

use App\User;

class UserRepository
{
    public function byId($id)
    {
        return User::find($id);
        return Question::find($id);

    }
}