<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/15
 * Time: 下午12:47
 */

namespace App\Repositories;

use App\Message;

class MessageRepository
{
    public function create(array $attributes)
    {
        return Message::create($attributes);
    }
}