<?php
/**
 * Created by PhpStorm.
 * User: jam
 * Date: 2017/10/10
 * Time: 下午10:54
 */

namespace App\Repositories;

use App\Answer;

class AnswerRepository
{
    public function create(array $attributes)
    {
        return Answer::create($attributes);
    }
}